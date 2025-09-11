<?php

namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use App\Models\JetApplicationModel as Application;
use App\Models\PaymentModel as Payment;
use App\Models\PaymentLogModel as PaymentLog;
use PaytmWallet; // anandsiddharth/laravel-paytm-wallet
use App\Models\FeeModel as Fee;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
        /**
         * Show payment summary screen (after form submit).
         */
        public function summary(Application $application)
        {
            // Fetch fee details (assuming fees table has only one row)
            $fee = Fee::first();

            if (!$fee) {
                abort(500, 'Fee details not configured.');
            }

            return view('payment.summary', [
                'application' => $application,
                'baseFee'     => $fee->base_fee,
                'gst'         => $fee->gst,
                'total'       => $fee->total_payable
            ]);
        }

        /**
         * Create a payment entry and redirect to Paytm.
         */
        public function initiate(Request $request, Application $application)
        {
            $fee = Fee::first();
            if (!$fee) {
                abort(500, 'Fee details not configured.');
            }

            // Create payment record with amount from fee table
            $payment = Payment::create([
                'application_id' => $application->id,
                'amount'         => $fee->total_payable,
                'status'         => 'PENDING',
                'order_id'       => uniqid('ORD-'),
            ]);

            PaymentLog::create([
            'payment_id'    => $payment->id,
            'application_id'=> $application->id, // <-- add this
            'stage'         => 'INIT_REQUEST',
            'payload'       => json_encode($request->all())
            ]);


            $paytm = PaytmWallet::with('receive');
            $paytm->prepare([
                'order'         => $payment->order_id,
                'user'          => $application->id,
                'mobile_number' => $application->mobile_no,
                'email'         => $application->email,
                'amount'        => $payment->amount,
                'callback_url'  => route('payment.callback')
            ]);

            return $paytm->receive();
        }



        /**
         * Handle Paytm callback after payment.
         */
        public function callback()
        {
            $transaction = PaytmWallet::with('receive');
            $response    = $transaction->response();

            $payment = Payment::where('order_id', $transaction->getOrderId())->firstOrFail();

            PaymentLog::create([
                'payment_id' => $payment->id,
                'stage'      => 'INIT_RESPONSE',
                'payload'    => json_encode($response),
            ]);

            $payment->status         = $transaction->isSuccessful() ? 'SUCCESS' : 'FAILED';
            $payment->gateway_txn_id = $transaction->getTransactionId();
            $payment->raw_response   = json_encode($response);
            $payment->save();

            return redirect()->route('payment.result', $payment->id)
                            ->with('status', $payment->status);
        }

        /**
         * Handle optional Paytm webhook.
         */
        public function webhook(Request $request)
        {
            $orderId = $request->get('ORDERID');
            $payment = Payment::where('order_id', $orderId)->first();

            if ($payment) {
                PaymentLog::create([
                    'payment_id' => $payment->id,
                    'stage'      => 'WEBHOOK',
                    'payload'    => json_encode($request->all()),
                ]);

                if ($payment->status !== $request->get('STATUS')) {
                    $payment->status = $request->get('STATUS');
                    $payment->save();
                }
            }

            return response()->json(['success' => true]);
        }

        public function showResumeForm()
        {
            return view('payments.resume');
        }

        /**
         * Handle resume-payment POST
         */
        public function resumePayment(Request $request)
        {
            $request->validate([
                'application_id' => 'nullable|string|max:30',
                'mobile_no'      => 'nullable|digits:10',
                'dob'            => 'nullable|date',
            ]);

            $applicationQuery = Application::query();

            if ($request->filled('application_id')) {
                $applicationQuery->where('application_no', $request->application_id);
            } elseif ($request->filled('mobile_no') && $request->filled('dob')) {
                $applicationQuery->where('mobile_no', $request->mobile_no)
                                ->whereDate('dob', $request->dob);
            } else {
                return back()->withErrors(['error' => 'Please provide either Application ID or Mobile & DOB.']);
            }

            $application = $applicationQuery->first();

            if (!$application) {
                return back()->withErrors(['error' => 'No matching application found.']);
            }

            $existingPayment = Payment::where('application_id', $application->id)
                ->where('status', 'success')
                ->first();

            if ($existingPayment) {
                return back()->withErrors(['error' => 'Payment is already completed for this application.']);
            }

            $payment = Payment::updateOrCreate(
                ['application_id' => $application->id, 'status' => 'pending'],
                [
                    'amount'        => config('bssc.fee_amount', 1180),
                    'currency'      => 'INR',
                    'gateway_order_id' => null,
                    'status'        => 'pending'
                ]
            );

            return redirect()->route('payment.summary', $payment->id);
        }

   
}
