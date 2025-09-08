<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 1. Check email/password
        $request->authenticate();

        // 2. Get the logged-in user
        $user = Auth::user();

        // 3. If 2FA is enabled for this user, generate & store OTP
        if (!empty($user->is_2fa_enabled) && $user->is_2fa_enabled) {
            $otp = random_int(100000, 999999);

            $user->update([
                'otp'            => $otp,
                'otp_expires_at' => now()->addMinutes(5),
            ]);

            // 🔹 For testing: print OTP to laravel.log
            \Log::info("2FA OTP for {$user->email}: {$otp}");

            // 🔹 Clear current login and stash user ID for 2FA step
            Auth::logout();
            $request->session()->put('2fa:user:id', $user->id);

            return redirect()
                ->route('2fa.verify.form')
                ->with('message', 'A one-time OTP has been generated. (Check log for testing)');
        }

        // 4. No 2FA → normal login
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    /**
     * Logout & destroy the session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
