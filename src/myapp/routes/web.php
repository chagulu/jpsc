<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Application\JetApplicationController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Admin\ApplicationSearchController;
use App\Http\Controllers\Auth\CandidateAuthController;
use App\Http\Controllers\Auth\TwoFactorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 1) Open routes
|--------------------------------------------------------------------------
| Public pages and generic auth entry points not bound to a specific guard.
*/
Route::get('/', function () {
    return redirect()->route('candidate.login');
}); // redirect to candidate login [2][8]

/** 2FA (generic admin login flow entry) */
Route::get('/2fa', [TwoFactorController::class, 'showForm'])->name('2fa.verify.form'); // 2FA form [13]
Route::post('/2fa', [TwoFactorController::class, 'verifyOtp'])->name('2fa.verify'); // 2FA verify [13]

/** JET application public-facing endpoints (public form + callbacks) */
Route::get('/jet-application', [JetApplicationController::class, 'showForm'])
    ->name('jet.application.form'); // public form GET [2]
    
Route::post('/jet-application', [JetApplicationController::class, 'submitForm'])
    ->middleware('throttle:5,1')
    ->name('jet.application.submit'); // submit with rate limit [7]

Route::put('jet-application/{application}', [JetApplicationController::class, 'updateForm'])
    ->name('jet.application.update'); // update (kept as-is) [2]

/** Payment (kept open as originally) */
Route::get('payment/summary/{application}', [PaymentController::class, 'summary'])
    ->name('payment.summary'); // summary [2]
Route::post('payment/initiate/{application}', [PaymentController::class, 'initiate'])
    ->name('payment.initiate'); // initiate [2]
Route::post('payment/callback', [PaymentController::class, 'callback'])
    ->name('payment.callback'); // gateway callback [2]

/** OTP endpoints (used by front-end for email/mobile verification on form) */
Route::post('/send-otp', [JetApplicationController::class, 'sendOtp'])->name('otp.send'); // send OTP [2]
Route::post('/verify-otp', [JetApplicationController::class, 'verifyOtp'])->name('otp.verify'); // verify OTP [2]

/*
|--------------------------------------------------------------------------
| 2) Candidate auth routes
|--------------------------------------------------------------------------
| Candidate login + OTP login and protected candidate pages under guard.
*/
Route::prefix('candidate')->name('candidate.')->group(function () {
    // login UI
    Route::get('/login', function () {
        return view('candidate.login');
    })->name('login'); // candidate login form [12]

    // OTP login flow
    Route::post('/request-otp', [CandidateAuthController::class, 'requestOtp'])
        ->name('requestOtp'); // request candidate OTP [12]
    Route::post('/verify-otp', [CandidateAuthController::class, 'verifyOtp'])
        ->name('verifyOtp'); // verify OTP & login [12]

    // protected candidate pages
    Route::middleware('auth:candidate')->group(function () {
        Route::get('/dashboard', function () {
            return view('candidate.dashboard');
        })->name('dashboard'); // candidate dashboard [6]

        Route::post('/logout', [CandidateAuthController::class, 'logout'])
            ->name('logout'); // logout [6]
    });
});

// candidate-protected application pages (outside /candidate, but guard-bound)
Route::get('/profile-summary', [JetApplicationController::class, 'profileSummary'])
    ->middleware('auth:candidate')
    ->name('profile.summary'); // profile summary [6]
Route::get('/candidate-application', [JetApplicationController::class, 'candidatedDashboardApplication'])
    ->middleware('auth:candidate')
    ->name('application'); // application dashboard [6]
Route::get('/get-profile-summary', [JetApplicationController::class, 'getProfileSummary'])
    ->middleware('auth:candidate')
    ->name('profile.summary.save'); // save summary action [6]

/*
|--------------------------------------------------------------------------
| 3) Admin auth routes
|--------------------------------------------------------------------------
| Admin-only routes guarded by default 'auth' middleware (session guard).
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard'); // admin dashboard [1][13]

Route::middleware('auth')->group(function () {
    // admin profile maintenance
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit'); // edit [1]
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update'); // update [1]
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); // delete [1]

    // admin application listing
    Route::get('/admin/applications', [ApplicationSearchController::class, 'index'])
        ->name('admin.applications.index'); // listing [8]
});

/*
|--------------------------------------------------------------------------
| Breeze / Jetstream default auth (Admin login, etc.)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
