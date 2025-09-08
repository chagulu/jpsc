<?php

namespace App\Http\Controllers;

use App\Models\JetApplicationModel;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class JetApplicationController extends Controller
{
    /**
     * Show the blank application form.
     */
    public function showForm()
    {
        // return view('jet_application');
        return view('jet_application_form1');
    }

    /**
     * Handle POST of JET form
     */
    public function submitForm(Request $request)
    {
        // 1. Log incoming payload for debugging
        Log::info('Incoming application payload', [
            'payload' => $request->all(),
            'ip'      => $request->ip(),
            'agent'   => $request->userAgent(),
        ]);

        try {
            $applicationNo = 'APP-' . time() . '-' . rand(1000, 9999);

            // Age calculation (optional)
            $age = Carbon::parse($request->dob)
                        ->diffInYears(Carbon::create(2025, 8, 1));

            // Wrap in transaction
            $application = DB::transaction(function () use ($request, $applicationNo) {
                // 1. Insert into candidates table
                Candidate::create([
                    'email'         => $request->emailId,
                    'mobile_number' => $request->mobileNumber,
                ]);

                // 2. Prepare attributes for applications table
                $attributes = [
                    'application_no'              => $applicationNo,
                    'aadhaar_card_number'         => $request->aadhaarCardNumber,
                    'mobile_no'                   => $request->mobileNumber,
                    'email'                       => $request->emailId,
                    'full_name'                   => $request->name,
                    'confirm_name'                => $request->confirmName,
                    'roll_number'                 => $request->rollNumber,
                    'rd_is_changed_name'          => $request->rdIsChangedName,
                    'have_you_ever_changed_name'  => $request->haveYouEverChangedName,
                    'changed_name'                => $request->changedName,
                    'verify_changed_name'         => $request->verifyChangedName,
                    'upload_supported_document'   => $request->uploadSupportedDocument,
                    'date_of_birth'               => $request->dateOfBirth,
                    'gender'                      => $request->gender,
                    'father_name'                 => $request->fatherName,
                    'mother_name'                 => $request->motherName,
                    'alternate_number'            => $request->alternateNumber,
                ];

                // 3. Insert into applications table
                return JetApplicationModel::create($attributes);
            });

            // 4. Check if application saved successfully
            if (!$application || !$application->id) {
                Log::error('Insert failed: no ID returned', ['data' => $request->all()]);
                return back()->withErrors(['db' => 'Failed to save application.'])->withInput();
            }

            // Success → redirect to summary page
            return redirect()
                ->route('profile.summary', $application->id)
                ->with('success', 'Application saved successfully.');

        } catch (\Throwable $e) {
            // 5. Handle errors
            Log::error('Error inserting application: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'data'  => $request->all(),
            ]);

            $msg = str_contains($e->getMessage(), 'Duplicate entry')
                ? 'Mobile number already exists for another application.'
                : 'Could not save application: '.$e->getMessage();

            return back()->withErrors(['db' => $msg])->withInput();
        }
    }


    /**
     * Edit
     */
    public function edit($id)
    {
        $application = JetApplicationModel::findOrFail($id);
        return view('applications.edit', compact('application'));
    }

    /**
     * Update
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'full_name' => 'required|string|max:150',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $application = JetApplicationModel::findOrFail($id);
        $age = $request->filled('dob')
            ? Carbon::parse($request->dob)->diffInYears(Carbon::create(2025, 8, 1))
            : $application->age;

        $application->update([
            'full_name'    => $request->full_name,
            'gender'       => $request->gender ?? $application->gender,
            'date_of_birth'=> $request->dob
                                  ? Carbon::parse($request->dob)->toDateString()
                                  : $application->date_of_birth,
            'mobile_no'    => $request->mobile_no ?? $application->mobile_no,
            'age'          => $age,
        ]);

        return redirect()
            ->route('application.edit', $application->id)
            ->with('success', 'Application updated successfully.');
    }

    /**
     * Payment summary page
     */
    public function summary($id)
    {
        $application = JetApplicationModel::findOrFail($id);

        $baseFee = 1000;
        $gst     = round($baseFee * 0.18, 2);
        $total   = $baseFee + $gst;

        return view('summary', [
            'application' => $application,
            'baseFee'     => $baseFee,
            'gst'         => $gst,
            'total'       => $total,
        ]);
    }

    public function profileSummary($id)
    {
        $application = JetApplicationModel::findOrFail($id);

        $baseFee = 1000;
        $gst     = round($baseFee * 0.18, 2);
        $total   = $baseFee + $gst;

        return view('profile_details', [
            'application' => $application,
            'baseFee'     => $baseFee,
            'gst'         => $gst,
            'total'       => $total,
        ]);
    }
}
