<?php

namespace App\Http\Controllers;

use App\Models\JetApplicationModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class JetApplicationController extends Controller
{
    /**
     * Show the blank application form.
     */
    public function showForm()
    {
        return view('jet_application');
    }

    /**
     * Handle POST of JET form
     */
    public function submitForm(Request $request)
    {
        // 1. Always log incoming payload for debugging
        Log::info('Incoming application payload', [
            'payload' => $request->all(),
            'ip'      => $request->ip(),
            'agent'   => $request->userAgent(),
        ]);

        // 2. Validation
        $rules = [
            'full_name'       => 'required|string|max:150',
            'gender'          => 'required|in:Male,Female,Transgender',
            'bihar_domicile'  => 'required|in:Yes,No',
            'category'        => 'required|string|max:10',
            'mobile_no'       => 'required|digits:10',
            'dob'             => 'required|date',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            // return with validation errors
            return back()->withErrors($validator)->withInput();
        }

        // 3. Try insert
        try {
            $applicationNo = 'APP-' . time() . '-' . rand(1000, 9999);

            // Age calculation (optional)
            $age = Carbon::parse($request->dob)
                         ->diffInYears(Carbon::create(2025, 8, 1));

            $application = JetApplicationModel::create([
                'application_no'            => $applicationNo,
                'full_name'                 => $request->full_name,
                'gender'                    => $request->gender,
                'bihar_domicile'            => $request->bihar_domicile,
                'category'                  => $request->category,
                'caste'                     => $request->caste ?? null,
                'non_creamy_layer'          => $request->non_creamy_layer ?? 'No',
                'pwd'                       => $request->pwd ?? 'No',
                'disability_type'           => $request->disability_type ?? null,
                'min_40_percent_disability' => $request->min_40_percent_disability ?? 'No',
                'ex_serviceman'             => $request->ex_serviceman ?? 'No',
                'service_in_defence_year'   => $request->service_in_defence_year ?? 0,
                'service_in_defence_month'  => $request->service_in_defence_month ?? 0,
                'service_in_defence_day'    => $request->service_in_defence_day ?? 0,
                'ncc_bihar_govt_service'    => $request->ncc_bihar_govt_service ?? 'No',
                'bihar_govt_employee'       => $request->bihar_govt_employee ?? 'No',
                'attempts_after_bihar_employee' => $request->attempts_after_bihar_employee ?? 0,
                'mobile_no'                 => $request->mobile_no,
                'email'                     => $request->email ?? null,
                'date_of_birth'             => Carbon::parse($request->dob)->toDateString(),
                'age'                       => $age,
                'status'                    => 'Draft',
            ]);

            if (!$application || !$application->id) {
                Log::error('Insert failed: no ID returned', ['data' => $request->all()]);
                return back()->withErrors(['db' => 'Failed to save application.'])->withInput();
            }

            // Success → load summary page
            return redirect()
                ->route('payment.summary', $application->id)
                ->with('success', 'Application saved successfully.');

        } catch (\Throwable $e) {
            // 4. Catch ANY DB/logic error
            Log::error('Error inserting application: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'data'  => $request->all(),
            ]);

            // Create human-friendly message or expose actual SQL (for dev)
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
}
