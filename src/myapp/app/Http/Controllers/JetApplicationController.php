<?php

namespace App\Http\Controllers;

use App\Models\JetApplicationModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
     * Store new application after validation.
     */
    public function submitForm(Request $request)
    {
        // 🔹 Log the full incoming payload
        Log::info('Incoming application payload', [
            'payload' => $request->all(),
            'ip'      => $request->ip(),
            'agent'   => $request->userAgent(),
        ]);

        // Basic validation (expand as needed)
        $rules = [
            'full_name' => 'required|string|max:150',
            // 'gender'           => 'required|in:Male,Female,Transgender',
            // 'bihar_domicile'   => 'required|in:Yes,No',
            // 'category'         => 'required|string|max:10',
            // 'mobile_no'        => 'required|digits:10',
            // 'dob'              => 'required|date',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Generate unique number
            $applicationNo = 'APP-' . time() . '-' . rand(1000, 9999);

            // Calculate age if DOB provided
            $age = null;
            if ($request->filled('dob')) {
                $age = Carbon::parse($request->dob)
                    ->diffInYears(Carbon::create(2025, 8, 1));
            }

            // Actual insert – supply defaults for required columns
            $application = JetApplicationModel::create([
                'application_no'            => $applicationNo,
                'full_name'                 => $request->full_name,
                'gender'                    => $request->gender ?? 'Male',
                'bihar_domicile'            => $request->bihar_domicile ?? 'No',
                'category'                  => $request->category ?? 'UR',
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
                'mobile_no'                 => $request->mobile_no ?? '9999999992',
                'email'                     => $request->email ?? null,
                'date_of_birth'             => $request->dob
                                                 ? Carbon::parse($request->dob)->toDateString()
                                                 : Carbon::now()->subYears(25)->toDateString(),
                'age'                       => $age,
                'status'                    => 'Draft',
            ]);

            if (!$application || !$application->id) {
                Log::error('Insert failed: no ID returned', ['data' => $request->all()]);
                return back()->with('error', 'Failed to save application.');
            }

            return redirect()
                ->route('payment.summary', $application->id)
                ->with('success', 'Application saved successfully.');
        } catch (\Throwable $e) {
            Log::error('Error inserting application: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'data'  => $request->all(),
            ]);

            return back()
                ->with('error', 'Something went wrong: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Edit form.
     */
    public function edit($id)
    {
        $application = JetApplicationModel::findOrFail($id);
        return view('applications.edit', compact('application'));
    }

    /**
     * Update existing application.
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
        $age = null;
        if ($request->filled('dob')) {
            $age = Carbon::parse($request->dob)
                ->diffInYears(Carbon::create(2025, 8, 1));
        }

        $application->update([
            'full_name'   => $request->full_name,
            'gender'      => $request->gender ?? $application->gender,
            'date_of_birth' => $request->dob
                                   ? Carbon::parse($request->dob)->toDateString()
                                   : $application->date_of_birth,
            'mobile_no'   => $request->mobile_no ?? $application->mobile_no,
            'age'         => $age,
        ]);

        return redirect()
            ->route('application.edit', $application->id)
            ->with('success', 'Application updated successfully.');
    }
}
