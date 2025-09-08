<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorController extends Controller
{
    public function showForm(Request $request)
    {
        return view('auth.2fa-verify')->with('message', $request->session()->get('message'));
    }

    public function verifyOtp(Request $request)
{
    $request->validate([
        'otp' => 'required|digits:6',
    ]);

    $userId = $request->session()->get('2fa:user:id');
    if (! $userId) {
        return redirect()->route('login')->withErrors('Session expired, login again.');
    }

    $user = User::find($userId);

    if (!$user || !$user->otp || $user->otp_expires_at < now() || $user->otp != $request->otp) {
        return back()->withErrors('Invalid or expired OTP.');
    }

    // Clear OTP
    $user->update([
        'otp' => null,
        'otp_expires_at' => null,
    ]);

    // Log in user
    Auth::login($user);

    // Forget session
    $request->session()->forget('2fa:user:id');

    return redirect()->intended(route('dashboard'));
}

}
