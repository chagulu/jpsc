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
     * Send OTP to candidate email
     */
    public function requestOtp(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);

        // find or create
        $candidate = Candidate::firstOrCreate(['email' => $validated['email']]);

        // 6-digit OTP
        $otp = random_int(100000, 999999);

        $candidate->update([
            'otp'            => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(5),
        ]);

        // basic mail (replace with queueable Mailable in production)
        Mail::raw("Your login OTP is {$otp}", function ($msg) use ($candidate) {
            $msg->to($candidate->email)->subject('Your Candidate Login OTP');
        });

        return response()->json([
            'success' => true,
            'message' => 'OTP sent to your email.',
        ]);
    }

    /**
     * Verify OTP & login
     */
    public function verifyOtp(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'otp'   => ['required', 'digits:6'],
        ]);

        $candidate = Candidate::where('email', $validated['email'])
            ->where('otp', $validated['otp'])
            ->where('otp_expires_at', '>', now())
            ->first();

        if (! $candidate) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired OTP.',
            ], 422);
        }

        // clear OTP on success
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
