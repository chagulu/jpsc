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
    $otp = rand(100000, 999999); // 6 digit OTP
    $key = "otp_{$request->type}_{$request->value}";

    // Store in cache (5 minutes)
    Cache::put($key, $otp, now()->addMinutes(5));

    // 3️⃣ Send OTP
    if ($request->type === 'mobile') {
        // TODO: integrate SMS service like Twilio or MSG91
        Log::info("Sending OTP {$otp} to mobile {$request->value}");
    } else {
        // Send via email
        Mail::raw("Your OTP is: $otp", function ($message) use ($request) {
            $message->to($request->value)
                    ->subject("Your OTP Code");
        });
    }

    return response()->json([
        'success' => true,
        'message' => "OTP sent successfully to {$request->type}.",
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
        Log::info('Incoming application payload', [
            'payload' => $request->all(),
            'ip'      => $request->ip(),
            'agent'   => $request->userAgent(),
        ]);

        $rules = [
            'emailId'         => 'required|email|max:150|unique:candidates,email',
            'name'            => 'required|string|max:150',
            'rollNumber'      => 'required|string|max:10',
            'gender'          => 'required|in:Male,Female,Third Gender',
            'dateOfBirth'     => 'required|date',
            'fatherName'      => 'required|string|max:20',
            'motherName'      => 'required|string|max:20',
            'mobileNumber'    => 'required|digits:10|unique:candidates,mobile_number',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $applicationNo = 'APP-' . time() . '-' . rand(1000, 9999);

            // 1️⃣ Find or create candidate
            $candidate = Candidate::where('email', $request->emailId)
                                ->orWhere('mobile_number', $request->mobileNumber)
                                ->first();

            if (! $candidate) {
                $candidate = Candidate::create([
                    'email'         => $request->emailId,
                    'mobile_number' => $request->mobileNumber,
                ]);
            }

            // 2️⃣ Ensure candidate doesn’t already have an application
            if (JetApplicationModel::where('candidate_id', $candidate->id)->exists()) {
                return back()->withErrors(['db' => 'You have already submitted an application.'])->withInput();
            }

            // 3️⃣ Prepare attributes
            $attributes = [
                'candidate_id'        => $candidate->id,
                'application_no'      => $applicationNo,
                'aadhaar_card_number' => $request->aadhaarCardNumber,
                'mobile_no'           => $request->mobileNumber,
                'email'               => $request->emailId,
                'full_name'           => $request->name,
                'confirm_name'        => $request->confirmName,
                'roll_number'         => $request->rollNumber,
                'rd_is_changed_name'  => $request->rdIsChangedName,
                'have_you_ever_changed_name' => $request->haveYouEverChangedName,
                'changed_name'        => $request->changedName,
                'verify_changed_name' => $request->verifyChangedName,
                'upload_supported_document' => $request->uploadSupportedDocument,
                'date_of_birth'       => $request->dateOfBirth,
                'gender'              => $request->gender,
                'father_name'         => $request->fatherName,
                'mother_name'         => $request->motherName,
                'alternate_number'    => $request->alternateNumber,
                'status'              => 'Draft',
                'submission_stage'    => 'Draft',
                'submitted_at'        => null,
                'last_edit_at'        => now(),
                'ip_address'          => $request->ip(),
                'user_agent'          => $request->userAgent(),
            ];

            // 4️⃣ Save application
            $application = JetApplicationModel::create($attributes);

            // 5️⃣ Update candidate with otr_no
            $candidate->update(['otr_no' => $applicationNo]);

            // 6️⃣ Auto-login candidate (if not already logged in)
            auth('candidate')->login($candidate);

            // 7️⃣ Redirect without ID in URL
            return redirect()
                ->route('profile.summary')
                ->with('success', 'Application saved successfully.');

        } catch (\Throwable $e) {
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

    public function profileSummary()
    {
        $candidate = auth('candidate')->user();

        if (! $candidate) {
            return redirect()->route('candidate.login');
        }

        $application = $candidate->applications()->latest()->first();

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

        if ($request->action === 'agree') {
            return view('application.thankYou', [
                'otr_number' => $application->application_no
            ]);
        } elseif ($request->action === 'update') {
            return view('application.applications_edit', [
                'application' => $application
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

      public function candidatedDashboardApplication(Request $request)
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
        return view('application.application', compact('application'));
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
        return view('candidate.candidate_profile', [
                'application' => $application
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
        return view('candidate.upload_document', [
                'application' => $application
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

    $request->validate([
        'photo'     => 'nullable|image|mimes:jpg,jpeg,png|max:20000',   // 200 KB
        'signature' => 'nullable|image|mimes:jpg,jpeg,png|max:10000',   // 100 KB
    ]);

    // Fetch or create related documents
    $document = $application->documents ?: new ApplicationDocument(['application_id' => $application->id]);

    if ($request->hasFile('photo')) {
        $document->photo = $request->file('photo')->store("candidate/{$candidate->id}", 'public');
    }

    if ($request->hasFile('signature')) {
        $document->signature = $request->file('signature')->store("candidate/{$candidate->id}", 'public');
    }

    $document->save();

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
        return view('candidate.other_details', [
                'application' => $application
        ]);
        
    }

    public function otherDetailsStore(){
        $candidate = auth('candidate')->user();

        if (! $candidate) {
            return redirect()->route('candidate.login')->withErrors(['auth' => 'Please log in first.']);
        }

        // Fetch the candidate's latest application
        $application = JetApplicationModel::where('candidate_id', $candidate->id)->latest()->first();

        if (! $application) {
            return back()->withErrors(['db' => 'No application found for your profile.']);
        }
        
        return redirect()
            ->route('candidate.education', $application->id)
            ->with('success', 'Application saved successfully.');
        
    }

    public function education(){
        $candidate = auth('candidate')->user();
        // dd($candidate);
        if (! $candidate) {
            return redirect()->route('candidate.login')->withErrors(['auth' => 'Please log in first.']);
        }

        // Fetch the candidate's latest application
        $application = JetApplicationModel::where('candidate_id', $candidate->id)->latest()->first();

        if (! $application) {
            return back()->withErrors(['db' => 'No application found for your profile.']);
        }

        return view('candidate.education', [
                'application' => $application
        ]);
    }

    public function educationStore(){
        $candidate = auth('candidate')->user();

        if (! $candidate) {
            return redirect()->route('candidate.login')->withErrors(['auth' => 'Please log in first.']);
        }

        // Fetch the candidate's latest application
        $application = JetApplicationModel::where('candidate_id', $candidate->id)->latest()->first();

        if (! $application) {
            return back()->withErrors(['db' => 'No application found for your profile.']);
        }
        return redirect()
                    ->route('candidate.preview', $application->id)
                    ->with('success', 'Application saved successfully.');
    }

    public function preview(){
        $candidate = auth('candidate')->user();
        // dd($candidate);
        if (! $candidate) {
            return redirect()->route('candidate.login')->withErrors(['auth' => 'Please log in first.']);
        }

        // Fetch the candidate's latest application
        $application = JetApplicationModel::where('candidate_id', $candidate->id)->latest()->first();

        if (! $application) {
            return back()->withErrors(['db' => 'No application found for your profile.']);
        }

        return view('candidate.preview', [
                'application' => $application
        ]);
    }

    public function previewStore(){
        $candidate = auth('candidate')->user();

        if (! $candidate) {
            return redirect()->route('candidate.login')->withErrors(['auth' => 'Please log in first.']);
        }

        // Fetch the candidate's latest application
        $application = JetApplicationModel::where('candidate_id', $candidate->id)->latest()->first();

        if (! $application) {
            return back()->withErrors(['db' => 'No application found for your profile.']);
        }
        return redirect()
                    ->route('candidate.completed', $application->id)
                    ->with('success', 'Application saved successfully.');
    }

    public function completed(){
        $candidate = auth('candidate')->user();
        // dd($candidate);
        if (! $candidate) {
            return redirect()->route('candidate.login')->withErrors(['auth' => 'Please log in first.']);
        }

        // Fetch the candidate's latest application
        $application = JetApplicationModel::where('candidate_id', $candidate->id)->latest()->first();

        if (! $application) {
            return back()->withErrors(['db' => 'No application found for your profile.']);
        }

        return view('candidate.completed', [
                'application' => $application
        ]);
    }
}
