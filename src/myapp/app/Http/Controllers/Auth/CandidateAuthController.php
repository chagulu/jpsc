<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CandidateAuthController extends Controller
{
    /**
     * Request OTP using email, mobile, or OTR No
     */
    public function requestOtp(Request $request)
    {
        $validated = $request->validate([
            'identifier' => ['required'], // email / mobile / otr_no
        ]);

        $identifier = $validated['identifier'];

        // Find candidate by email, mobile, or otr_no
        $candidate = Candidate::where('email', $identifier)
                        ->orWhere('mobile_number', $identifier)
                        ->orWhere('otr_no', $identifier)
                        ->first();

        if (! $candidate) {
            return response()->json([
                'success' => false,
                'message' => 'Candidate not found.'
            ], 404);
        }

        // Generate 6-digit OTP
        $otp = random_int(100000, 999999);

        $candidate->update([
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(5),
        ]);

        // Send OTP via email
        Mail::raw("Your login OTP is {$otp}", function ($msg) use ($candidate) {
            $msg->to($candidate->email)
                ->subject('Your Candidate Login OTP');
        });

        // Send OTP via mobile (stub)
        // SmsService::send($candidate->mobile_number, "Your OTP is {$otp}");

        return response()->json([
            'success' => true,
            'message' => 'OTP sent to your email and mobile number.'
        ]);
    }

    /**
     * Verify OTP and login candidate
     */
    public function verifyOtp(Request $request)
    {
        $validated = $request->validate([
            'identifier' => ['required'],
            'otp' => ['required', 'digits:6'],
        ]);

        $candidate = Candidate::where(function($q) use ($validated) {
                            $q->where('email', $validated['identifier'])
                              ->orWhere('mobile_number', $validated['identifier'])
                              ->orWhere('otr_no', $validated['identifier']);
                        })
                        ->where('otp', $validated['otp'])
                        ->where('otp_expires_at', '>', now())
                        ->first();

        if (! $candidate) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired OTP.'
            ], 422);
        }

        // Clear OTP
        $candidate->update([
            'otp' => null,
            'otp_expires_at' => null,
        ]);

        Auth::guard('candidate')->login($candidate);

        return response()->json([
            'success' => true,
            'message' => 'Logged in successfully.',
        ]);
    }

    /**
     * Candidate logout
     */
    public function logout()
    {
        Auth::guard('candidate')->logout();
        return redirect()->route('candidate.login');
    }
}
