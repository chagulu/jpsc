<?php

namespace App\Http\Controllers\Application;

use App\Models\JetApplicationModel;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\ApplicationDocument;
use App\Models\ApplicationEducation;
use App\Models\ApplicationProgress;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Jobs\ProcessCandidateApplication;
use App\Jobs\SendOtpJob;
use App\Models\ApplicantAddress;

class JetApplicationController extends Controller
{
    /**
     * Show the blank application form.
     */
    public function showForm()
    {
        return view('application.jet_application_form');
    }

    /**
     * Send OTP for mobile/email
     */
    /**
 * Send OTP for mobile/email
 */
    public function sendOtp(Request $request)
{
    $request->validate([
        'type'  => 'required|in:mobile,email',
        'value' => 'required|string'
    ]);

    // 1️⃣ Check if candidate already exists
    if ($request->type === 'mobile') {
        if (Candidate::where('mobile_number', $request->value)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Mobile number already exists'
            ]);
        }
    } elseif ($request->type === 'email') {
        if (Candidate::where('email', $request->value)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Email already exists'
            ]);
        }
    }

    // 2️⃣ Generate OTP
    $otp = rand(100000, 999999); // 6-digit OTP
    $key = "otp_{$request->type}_{$request->value}";

    // Store in cache for 5 minutes
    Cache::put($key, $otp, now()->addMinutes(5));

    // 3️⃣ Dispatch Job (Queue)
    SendOtpJob::dispatch($request->type, $request->value, $otp);

    return response()->json([
        'success' => true,
        'message' => "OTP sent successfully to {$request->type}."
    ]);
}


    /**
     * Verify OTP for mobile/email
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'type'  => 'required|in:mobile,email',
            'value' => 'required|string',
            'otp'   => 'required|numeric'
        ]);

        $key = "otp_{$request->type}_{$request->value}";
        $cachedOtp = Cache::get($key);

        if (!$cachedOtp) {
            return response()->json([
                'success' => false,
                'message' => 'OTP expired or not found',
            ], 400);
        }

        if ($cachedOtp != $request->otp) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP',
            ], 400);
        }

        // ✅ OTP verified → remove from cache
        Cache::forget($key);

        // ✅ Save verification flag in session
        session([
            "otp_verified.{$request->type}" => $request->value
        ]);

        return response()->json([
            'success' => true,
            'message' => ucfirst($request->type).' OTP verified successfully',
        ]);
    }


    /**
     * Handle POST of JET form
     */
 
  public function submitForm(Request $request)
{
    // 1) Minimal logging
    Log::info('Incoming application', [
        'mobile' => $request->input('mobileNumber'),
        'email'  => $request->input('emailId'),
        'ip'     => $request->ip(),
    ]);

    // 2) Validation mapped to actual DB columns
    $validated = $request->validate([
        'emailId'      => 'required|email|max:150|unique:candidates,email',           // candidates.email
        'name'         => 'required|string|max:150',                                  // applications.full_name
        'rollNumber'   => 'required|string|max:10',                                   // applications.roll_number
        'gender'       => 'required|in:Male,Female,Third Gender',                     // applications.gender
        'dateOfBirth'  => 'required|date',                                            // applications.date_of_birth
        'fatherName'   => 'required|string|max:20',                                   // applications.father_name
        'motherName'   => 'required|string|max:20',                                   // applications.mother_name
        'mobileNumber' => 'required|digits:10|unique:candidates,mobile_number',       // candidates.mobile_number
        'aadhaarCardNumber' => 'nullable|string|size:12',                             // applications.aadhaar_card_number
    ]); // [15]

    // 3) OTP verification via session
    if (session('otp_verified.mobile') !== $request->input('mobileNumber')) {
        return back()->withErrors(['db' => 'Mobile number is not verified'])->withInput();
    }
    if (session('otp_verified.email') !== $request->input('emailId')) {
        return back()->withErrors(['db' => 'Email Id is not verified'])->withInput();
    }

    try {
        // 4) Candidate upsert keyed by email & mobile_number
        $applicationNo = 'APP-' . now()->timestamp . '-' . random_int(1000, 9999);

        $candidate = Candidate::firstOrCreate(
            [
                'email'         => $request->input('emailId'),
                'mobile_number' => $request->input('mobileNumber'),
            ],
            [
                'otr_no' => $applicationNo,
            ]
        ); // [2]

        if (JetApplicationModel::where('candidate_id', $candidate->id)->exists()) {
            return back()->withErrors(['db' => 'You have already submitted an application.'])->withInput();
        }

        // 5) Build normalized application payload for the Job using model columns
        $appData = [
            'application_no'       => $applicationNo,
            'aadhaar_card_number'  => $request->input('aadhaarCardNumber'),
            'full_name'            => $request->input('name'),
            'roll_number'          => $request->input('rollNumber'),
            'gender'               => $request->input('gender'),
            'date_of_birth'        => $request->input('dateOfBirth'),
            'father_name'          => $request->input('fatherName'),
            'mother_name'          => $request->input('motherName'),
            'mobile_no'            => $request->input('mobileNumber'),
            'email'                => $request->input('emailId'),
            'candidate_id'         => $candidate->id,
            'ip_address'           => $request->ip(),
            'user_agent'           => (string) $request->header('User-Agent'),
            'submission_stage'     => 'Draft',
            'submitted_at'         => now(),
            'form_json'            => $request->except(['_token']), // optional snapshot
            // boolean flags can be filled later in subsequent steps
        ];

        // 6) Minimal session preview for UI
        session([
            'application_preview' => [
                'application_no'      => $appData['application_no'],
                'aadhaar_card_number' => $appData['aadhaar_card_number'],
                'full_name'           => $appData['full_name'],
                'mobile_no'           => $appData['mobile_no'],
                'email'               => $appData['email'],
                'date_of_birth'       => $appData['date_of_birth'],
                'gender'              => $appData['gender'],
                'father_name'         => $appData['father_name'],
                'mother_name'         => $appData['mother_name'],
            ]
        ]); // [2]

        // 7) Dispatch background job with normalized payload
        ProcessCandidateApplication::dispatch($candidate, $appData); // ensure job ctor matches

        // 8) Auto-login candidate
        auth('candidate')->login($candidate);

        // 9) Redirect
        return redirect()->route('profile.summary')->with('success', 'Application is being processed and you are logged in.');

    } catch (\Throwable $e) {
        Log::error('Application submission failed', [
            'message' => $e->getMessage(),
            'trace'   => $e->getTraceAsString(),
            'request' => $request->only('emailId', 'mobileNumber'),
        ]);

        $msg = str_contains($e->getMessage(), 'Duplicate entry')
            ? 'Mobile number or email already exists for another candidate.'
            : 'Could not save application: '.$e->getMessage();

        return back()->withErrors(['db' => $msg])->withInput();
    }
}






    public function profileSummary()
{
    $candidate = auth('candidate')->user();

    if (! $candidate) {
        return redirect()->route('candidate.login');
    }

    // 1️⃣ Try fetching application from DB
    $application = $candidate->applications()->latest()->first();

    // 2️⃣ If not inserted yet, fallback to session preview
    if (! $application && session()->has('application_preview')) {
        $application = (object) session('application_preview');
    }

    if (! $application) {
        return redirect()->route('jet.application.form')
                         ->withErrors(['db' => 'No application found for your account.']);
    }

    $baseFee = 1000;
    $gst     = round($baseFee * 0.18, 2);
    $total   = $baseFee + $gst;

    return view('application.profile_details', [
        'application' => $application,
        'baseFee'     => $baseFee,
        'gst'         => $gst,
        'total'       => $total,
    ]);
}



    public function getProfileSummary(Request $request)
    {
        // Get logged-in candidate
        $candidate = auth('candidate')->user();

        if (! $candidate) {
            return redirect()->route('candidate.login')->withErrors(['auth' => 'Please log in first.']);
        }

        // Fetch the candidate's latest application
        $application = JetApplicationModel::where('candidate_id', $candidate->id)->latest()->first();

        if (! $application) {
            return back()->withErrors(['db' => 'No application found for your profile.']);
        }

        $progress_status = $this->showStep($application->id,'profile');
        if ($request->action === 'agree') {
            // $this->updateProgressBar($application->id, 'profile');
            return view('application.thankYou', [
                'otr_number' => $application->application_no
            ]);
        } elseif ($request->action === 'update') {
            return view('application.applications_edit', [
                'application' => $application,
                'progress_status' => $progress_status
            ]);
        }

        return back()->withErrors(['action' => 'Invalid action provided.']);
    }


    public function thankyou(){
        return view('thankYou');
    }

    public function updateForm(Request $request, $id){
        // return $request->all();
        Log::info('Incoming application payload', [
            'payload' => $request->all(),
            'ip'      => $request->ip(),
            'agent'   => $request->userAgent(),
        ]);

        $rules = [
            //'email'           => 'required|email|max:150|unique:users,email', // Assuming 'users' is your table name
            'name'       => 'required|string|max:150',
            'rollNumber'      => 'required|string|max:10',
            'gender'          => 'required|in:Male,Female,Third Gender',
            'dateOfBirth'     => 'required|date',
            'fatherName'      => 'required|string|max:20',
            'motherName'      => 'required|string|max:20',
            //'mobileNumber'    => 'required|digits:10|unique:users,mobileNumber', // Assuming 'users' is your table name
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            // return with validation errors
            return back()->withErrors($validator)->withInput();
        }
        try {
            $application = JetApplicationModel::findOrFail($id);
            $age = $request->filled('dob')
                ? Carbon::parse($request->dob)->diffInYears(Carbon::create(2025, 8, 1))
                : $application->age;

            $application->update([
                'aadhaar_card_number' => $request->aadhaarCardNumber,
                'email' => $request->emailId,
                'name' => $request->name,
                'confirm_name' => $request->confirmName,
                'roll_number' => $request->rollNumber,
                'rd_is_changed_name' => $request->rdIsChangedName,
                'have_you_ever_changed_name' => $request->haveYouEverChangedName,
                'changed_name' => $request->changedName,
                'verify_changed_name' => $request->verifyChangedName,
                'upload_supported_document' => $request->uploadSupportedDocument,
                'date_of_birth' => $request->dateOfBirth,
                'gender' => $request->gender,
                'father_name' => $request->fatherName,
                'mother_name' => $request->motherName,
                'alternate_number' => $request->alternateNumber,
                'status'                => 'Draft',
                'submission_stage'      => 'Draft',
                'submitted_at'          => null,
                'last_edit_at'          => now(),
                'ip_address'            => $request->ip(),
                'user_agent'            => $request->userAgent(),
            ]);
            // $this->updateProgressBar($application->id, 'profile');

            if(isset($request->internal_profile) && $request->internal_profile === "internal_profile"){
                return redirect()
                    ->route('candidate.uploadDocuments', $application->id)
                    ->with('success', 'Application saved successfully.');
            }
            return redirect()
                ->route('profile.summary', $application->id)
                ->with('success', 'Application saved successfully.');
        }catch (\Throwable $e) {
            Log::error('Error inserting application: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'data'  => $request->all(),
            ]);

            $msg = str_contains($e->getMessage(), 'Duplicate entry')
                ? 'Mobile number or email already exists for another candidate.'
                : 'Could not save application: '.$e->getMessage();

            return back()->withErrors(['db' => $msg])->withInput();
        }
    }

    //   public function candidatedDashboardApplication(Request $request)
    //   {
    //     // Get logged-in candidate
    //     $candidate = auth('candidate')->user();

    //     if (! $candidate) {
    //         return redirect()->route('candidate.login')->withErrors(['auth' => 'Please log in first.']);
    //     }

    //     // Fetch the candidate's latest application
    //     $application = JetApplicationModel::where('candidate_id', $candidate->id)->latest()->first();

    //     if (! $application) {
    //         return back()->withErrors(['db' => 'No application found for your profile.']);
    //     }
    //     return view('application.application', compact('application'));
    // }

    public function dashboard()
{
    $candidate = auth('candidate')->user();

    if (! $candidate) {
        return redirect()->route('candidate.login')
            ->withErrors(['auth' => 'Please log in first.']);
    }

    // Fetch the candidate's latest application
    $application = JetApplicationModel::with('documents')
        ->where('candidate_id', $candidate->id)
        ->latest()
        ->first();

    if (! $application) {
        return back()->withErrors(['db' => 'No application found for your profile.']);
    }

    // ✅ Use candidate's verification columns instead of application
    $statusChecks = [
        'Email Verified'          => !empty($candidate->email_verified_at),
        'Mobile Verified'         => !empty($candidate->mobile_verified_at),
        'Profile Details Updated' => !empty($application->full_name),
        'Photo Uploaded'          => optional($application->documents)->photo ? true : false,
        'Signature Uploaded'      => optional($application->documents)->signature ? true : false,
        'Other Details Updated'   => !empty($application->category),
        'Education & Experience'  => $application->education()->exists(),
        'Finally Submitted'       => $application->status === 'Submitted',
    ];

    // Calculate completion percentage
    $completedCount = collect($statusChecks)->filter()->count();
    $totalSteps     = count($statusChecks);
    $percentage     = round(($completedCount / $totalSteps) * 100);

    return view('candidate.dashboard', [
        'candidate'     => $candidate,
        'application'   => $application,
        'statusChecks'  => $statusChecks,
        'percentage'    => $percentage,
    ]);
}



    public function applicationProfile(){
        $candidate = auth('candidate')->user();

        if (! $candidate) {
            return redirect()->route('candidate.login')->withErrors(['auth' => 'Please log in first.']);
        }

        // Fetch the candidate's latest application
        $application = JetApplicationModel::where('candidate_id', $candidate->id)->latest()->first();

        if (! $application) {
            return back()->withErrors(['db' => 'No application found for your profile.']);
        }
        $progress_status = $this->showStep($application->id,'photo');
        return view('candidate.candidate_profile', [
                'application' => $application,
                'progress_status' => $progress_status
        ]);
    }

    public function uploadDocuments(){
        $candidate = auth('candidate')->user();

        if (! $candidate) {
            return redirect()->route('candidate.login')->withErrors(['auth' => 'Please log in first.']);
        }

        // Fetch the candidate's latest application
        $application = JetApplicationModel::where('candidate_id', $candidate->id)->latest()->first();

        if (! $application) {
            return back()->withErrors(['db' => 'No application found for your profile.']);
        }
        $this->updateProgressBar($application->id, 'profile');
        $progress_status = $this->showStep($application->id,'photo');
        return view('candidate.upload_document', [
                'application' => $application,
                'progress_status' => $progress_status ?? null
        ]);
    }

    


public function uploadDocumentsStore(Request $request, $applicationId)
{
    $candidate = auth('candidate')->user();

    if (!$candidate) {
        return redirect()
            ->route('candidate.login')
            ->withErrors(['auth' => 'Please log in first.']);
    }

    $application = JetApplicationModel::where('id', $applicationId)
        ->where('candidate_id', $candidate->id)
        ->first();

    if (!$application) {
        return back()->withErrors(['db' => 'No application found for your profile.']);
    }

    // Validate uploaded files
    $request->validate([
        'photo'     => 'nullable|image|mimes:jpg,jpeg,png|max:200',   // 200 KB
        'signature' => 'nullable|image|mimes:jpg,jpeg,png|max:200',   // 100 KB
    ]);

    // Fetch existing document or create new
    $document = $application->documents ?: new ApplicationDocument(['application_id' => $application->id]);

    // Handle photo upload
    if ($request->hasFile('photo')) {
        // Optionally delete old file
        if ($document->photo && \Storage::disk('public')->exists($document->photo)) {
            \Storage::disk('public')->delete($document->photo);
        }
        $document->photo = $request->file('photo')->store("candidate/{$candidate->id}", 'public');
    }

    // Handle signature upload
    if ($request->hasFile('signature')) {
        // Optionally delete old file
        if ($document->signature && \Storage::disk('public')->exists($document->signature)) {
            \Storage::disk('public')->delete($document->signature);
        }
        $document->signature = $request->file('signature')->store("candidate/{$candidate->id}", 'public');
    }

    $document->save();
    $this->updateProgressBar($application->id, 'photo');

    return redirect()
        ->route('candidate.otherDetails', $application->id)
        ->with('success', 'Documents uploaded successfully.');
}




    public function otherDetails(){
        $candidate = auth('candidate')->user();
        


        if (! $candidate) {
            return redirect()->route('candidate.login')->withErrors(['auth' => 'Please log in first.']);
        }

        // Fetch the candidate's latest application
        $application = JetApplicationModel::where('candidate_id', $candidate->id)->latest()->first();

        if (! $application) {
            return back()->withErrors(['db' => 'No application found for your profile.']);
        }
        $progress_status = $this->showStep($application->id,'photo');
        if(($progress_status['step_name'] === 'photo' && $progress_status['status'] !== 'Completed')
                            || empty($progress_status['step_name'])
        ){
            return redirect()
            ->route('candidate.uploadDocuments', $application->id);
        }
        $progress_status = $this->showStep($application->id,'other_details');
        return view('candidate.other_details', [
                'application' => $application,
                'progress_status' => $progress_status
        ]);
        
    }

  public function otherDetailsStore(Request $request, $applicationId)
{
    $candidate = auth('candidate')->user();

    if (!$candidate) {
        return redirect()->route('candidate.login')
            ->withErrors(['auth' => 'Please log in first.']);
    }

    // ✅ Validation rules
    $validator = Validator::make($request->all(), [
        'dob'      => ['required', 'date'],
        'gender'   => ['required', 'in:Male,Female,Transgender'],
        'category' => ['required', 'in:UR,EWS,SC,ST,BC-I,BC-II,OBC,EBC,BC'],

        // Correspondence address
        'address_line1' => 'required|string|max:255',
        'address_line2' => 'nullable|string|max:255',
        'city'          => 'required|string|max:100',
        'district'      => 'nullable|string|max:100',
        'state'         => 'required|string|max:100',
        'pincode'       => 'required|string|max:10',
        'country'       => 'required|string|max:100',

        // Permanent address (optional)
        'permanentAddress1' => 'nullable|string|max:255',
        'permanentAddress2' => 'nullable|string|max:255',
        'permanentCity'     => 'nullable|string|max:100',
        'permanentDistrict' => 'nullable|string|max:100',
        'permanentState'    => 'nullable|string|max:100',
        'permanentPinCode'  => 'nullable|string|max:10',
        'permanentCountry'  => 'nullable|string|max:100',
    ]);

    // ✅ Validation fails
    if ($validator->fails()) {
        return redirect()
            ->back()
            ->withErrors($validator)
            ->withInput();
    }

    $validated = $validator->validated();

    // ✅ Find application for current candidate
    $application = JetApplicationModel::where('id', $applicationId)
        ->where('candidate_id', $candidate->id)
        ->first();

    if (!$application) {
        return back()->withErrors(['db' => 'No application found for your profile.']);
    }

    // ✅ Save within a transaction
    DB::transaction(function () use ($application, $validated) {
        // Update application main fields
        $application->update([
            'date_of_birth' => $validated['dob'],
            'gender'        => $validated['gender'],
            'category'      => $validated['category'],
            'last_edit_at'  => now(),
        ]);

        // Correspondence address
        ApplicantAddress::updateOrCreate(
            ['application_id' => $application->id, 'address_type' => 'correspondence'],
            [
                'address_line1' => $validated['address_line1'],
                'address_line2' => $validated['address_line2'] ?? null,
                'city'          => $validated['city'],
                'district'      => $validated['district'] ?? null,
                'state'         => $validated['state'],
                'pincode'       => $validated['pincode'],
                'country'       => $validated['country'],
            ]
        );

        // Permanent address (fallback to correspondence if empty)
        ApplicantAddress::updateOrCreate(
            ['application_id' => $application->id, 'address_type' => 'permanent'],
            [
                'address_line1' => $validated['permanentAddress1'] ?? $validated['address_line1'],
                'address_line2' => $validated['permanentAddress2'] ?? $validated['address_line2'],
                'city'          => $validated['permanentCity'] ?? $validated['city'],
                'district'      => $validated['permanentDistrict'] ?? $validated['district'],
                'state'         => $validated['permanentState'] ?? $validated['state'],
                'pincode'       => $validated['permanentPinCode'] ?? $validated['pincode'],
                'country'       => $validated['permanentCountry'] ?? $validated['country'],
            ]
        );
    });

    // ✅ Update progress bar if you have one
    $this->updateProgressBar($application->id, 'other_details');

    return redirect()->route('candidate.education', $application->id)
        ->with('success', 'Other details saved successfully!');
}



    public function education(){
    $candidate = auth('candidate')->user();
    if (! $candidate) {
        return redirect()->route('candidate.login')->withErrors(['auth' => 'Please log in first.']);
    }

    $application = JetApplicationModel::where('candidate_id', $candidate->id)->latest()->first();

    if (! $application) {
        return back()->withErrors(['db' => 'No application found for your profile.']);
    }
    $progress_status = $this->showStep($application->id,'other_details');
    if(($progress_status['step_name'] === 'other_details' && $progress_status['status'] !== 'Completed')
                        || empty($progress_status['step_name'])
    ){
        return redirect()
        ->route('candidate.otherDetails', $application->id);
    }

    // Fetch existing education records
    $educations = $application->education()->get();
    $progress_status = $this->showStep($application->id,'education');
        return view('candidate.education', [
                'application' => $application,
                'educations'  => $educations,
                'progress_status' => $progress_status
        ]);
}


    public function educationStore(Request $request)
{
    $candidate = auth('candidate')->user();

    if (! $candidate) {
        return redirect()->route('candidate.login')
            ->withErrors(['auth' => 'Please log in first.']);
    }

    // Fetch candidate's latest application
    $application = JetApplicationModel::where('candidate_id', $candidate->id)
        ->latest()
        ->first();

    if (! $application) {
        return back()->withErrors(['db' => 'No application found for your profile.']);
    }

    // Validate array of educations
    $validated = $request->validate([
        'education'                       => 'required|array',
        'education.*.id'                  => 'nullable|exists:application_educations,id',
        'education.*.exam_name'           => 'required|string|max:150',
        'education.*.degree'              => 'required|string|max:150',
        'education.*.subject'             => 'required|string|max:150',
        'education.*.school_college'     => 'required|string|max:200',
        'education.*.board_university'   => 'required|string|max:200',
        'education.*.status'              => 'nullable|in:Completed,Pursuing',
        'education.*.passing_month'       => 'required|string|max:20',
        'education.*.passing_year'        => 'required|digits:4',
        'education.*.marks_obtained'      => 'required|numeric|min:0',
        'education.*.division'            => 'nullable|in:First,Second,Third',
        'education.*.certificate_number'  => 'required|string|max:100',
    ]);

    // Get all existing educations for this application
    $existingEducationIds = $application->education()->pluck('id')->toArray();

    // Collect submitted IDs
    $submittedIds = collect($validated['education'])->pluck('id')->filter()->toArray();

    // Delete the records that are in DB but not in submitted request
    $idsToDelete = array_diff($existingEducationIds, $submittedIds);
    if (!empty($idsToDelete)) {
        \App\Models\ApplicationEducation::whereIn('id', $idsToDelete)->delete();
    }

    // Update existing or create new
    foreach ($validated['education'] as $edu) {
        if (!empty($edu['id'])) {
            // Update existing
            \App\Models\ApplicationEducation::find($edu['id'])->update($edu);
        } else {
            // Create new
            $edu['application_id'] = $application->id;
            \App\Models\ApplicationEducation::create($edu);
        }
    }
    $this->updateProgressBar($application->id, 'education');
    return redirect()
        ->route('candidate.preview', $application->id)
        ->with('success', 'Education details updated successfully.');
}
 

public function previewStore()
    {
       
    $candidate = auth('candidate')->user();

    if (! $candidate) {
        return redirect()->route('candidate.login')
            ->withErrors(['auth' => 'Please log in first.']);
    }

    // Fetch the candidate's latest application
    $application = JetApplicationModel::where('candidate_id', $candidate->id)
        ->latest()
        ->first();

    if (! $application) {
        return back()->withErrors(['db' => 'No application found for your profile.']);
    }

    

    return redirect()
        ->route('candidate.completed', $application->id)
        ->with('success', 'Application submitted successfully.');
}


    public function completed(){
        $candidate = auth('candidate')->user();
        // dd($candidate);
        if (! $candidate) {
            return redirect()->route('candidate.login')->withErrors(['auth' => 'Please log in first.']);
        }

        // Fetch the candidate's latest application
        $application = JetApplicationModel::where('candidate_id', $candidate->id)->latest()->first();
        $progress_status = $this->showStep($application->id,'education');
        if(($progress_status['step_name'] === 'education' && $progress_status['status'] !== 'Completed')
                            || empty($progress_status['step_name'])
        ){
            return redirect()
            ->route('candidate.education', $application->id);
        }
        if (! $application) {
            return back()->withErrors(['db' => 'No application found for your profile.']);
        }
         // ✅ Update status to Submitted
            $application->status = 'Submitted';
            $application->save();

        return view('candidate.completed', [
                'application' => $application
        ]);
    }

    public function updateProgressBar($application_id, $type){
        $percentage = match ($type) {
            'profile'       => 40,
            'photo'         => 10,
            'other_details' => 10,
            'education'     => 40,
            default         => 0, // fallback if $type doesn’t match
        };
        ApplicationProgress::updateOrCreate(
            // 🔍 Match conditions
            [
                'application_id' => $application_id,
                'step_name'           => $type,
            ],
            // ✏️ Fields to update if found, or create if not
            [
                'status'     => 'Completed',
                'percentage' => $percentage,
            ]
        );
    }

    public function showStep($applicationId, $type)
    {
        $progress = ApplicationProgress::where('application_id', $applicationId)
                    ->where('step_name', $type)
                    ->first();


            $isCompleted['step_name'] = $progress->step_name ?? null;
            $isCompleted['status'] = $progress->status?? null;
            $isCompleted['percentage'] = $progress->percentage?? null;
            $isCompleted['created_at'] = $progress->created_at?? null;

        return $isCompleted;
        
    }
    
        public function downloadPdf($id)
{
    $application = JetApplicationModel::with(['education','documents'])->findOrFail($id);

    $progress = \DB::table('progress_status')
        ->where('application_id', $application->id)
        ->orderBy('created_at', 'asc')
        ->get();

    $pdf = Pdf::loadView('candidate.printPdf', compact('application','progress'));
    return $pdf->download("application_{$application->application_no}.pdf");
}

public function printPdf($id)
{
    $application = JetApplicationModel::with(['education','documents'])->findOrFail($id);

    $progress = \DB::table('progress_status')
        ->where('application_id', $application->id)
        ->orderBy('created_at', 'asc')
        ->get();

    $pdf = Pdf::loadView('candidate.printPdf', compact('application','progress'));
    return $pdf->stream("application_{$application->application_no}.pdf");
}


        public function viewPdf($id)
        {
            $application = JetApplicationModel::with(['education','documents'])->findOrFail($id);

            $pdf = Pdf::loadView('candidate.printPdf', compact('application'));
            return $pdf->stream("application_{$application->application_no}.pdf");
        }

        // Candidate self-preview (latest application)
   public function preview()
{
    $candidate = auth('candidate')->user();

    if (! $candidate) {
        return redirect()->route('candidate.login')
            ->withErrors(['auth' => 'Please log in first.']);
    }

    // Fetch latest application with related data
    $application = JetApplicationModel::where('candidate_id', $candidate->id)
        ->with([
            'education',
            'documents',
            'permanentAddress',
            'correspondenceAddress'
        ])
        ->latest()
        ->first();

    $progress_status = $this->showStep($application->id,'education');
    if(($progress_status['step_name'] === 'education' && $progress_status['status'] !== 'Completed')
                        || empty($progress_status['step_name'])
    ){
        return redirect()
        ->route('candidate.education', $application->id);
    }
    if (! $application) {
        return redirect()->route('candidate.dashboard')
            ->withErrors(['application' => 'No application found.']);
    }

    return view('candidate.preview', compact('application'));
}


    // Preview by admin or by ID (used in Completed page links)
    public function showPreview($id)
    {
        $application = JetApplicationModel::with(['education','documents'])->findOrFail($id);

        $progress = \DB::table('progress_status')
            ->where('application_id', $application->id)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('candidate.preview', compact('application','progress'));
    }


        }
