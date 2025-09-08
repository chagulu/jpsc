<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JetApplicationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\ApplicationSearchController;
use App\Http\Controllers\Auth\CandidateAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Default route → Candidate login
Route::get('/', function () {
    return redirect()->route('candidate.login');  // Redirect to candidate login
});

// Dashboard (requires authentication and email verification)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated user routes (profile management)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin application listing
    Route::get('/admin/applications', [ApplicationSearchController::class, 'index'])
        ->name('admin.applications.index');
});

/*
|--------------------------------------------------------------------------
| JET Application Public Form Routes
|--------------------------------------------------------------------------
*/
Route::get('/jet-application', [JetApplicationController::class, 'showForm'])
    ->name('jet.application.form');

Route::post('/jet-application', [JetApplicationController::class, 'submitForm'])
    ->name('jet.application.submit')
    ->middleware('throttle:5,1');

Route::get('/profile-summary/{id}', [JetApplicationController::class, 'profileSummary'])
    ->name('profile.summary');
Route::get('/payment-summary/{id}', [JetApplicationController::class, 'summary'])
    ->name('payment.summary');

Route::get('payment/summary/{application}', [PaymentController::class, 'summary'])->name('payment.summary');
Route::post('payment/initiate/{application}', [PaymentController::class, 'initiate'])->name('payment.initiate');
Route::post('payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');

/*
|--------------------------------------------------------------------------
| Candidate OTP Login Routes
|--------------------------------------------------------------------------
*/
Route::prefix('candidate')->name('candidate.')->group(function () {

    // Candidate login form (enter email / mobile / otr_no)
    Route::get('/login', function () {
        return view('candidate.login');
    })->name('login');

    // Request OTP
    Route::post('/request-otp', [CandidateAuthController::class, 'requestOtp'])
        ->name('requestOtp');

    // Verify OTP & login
    Route::post('/verify-otp', [CandidateAuthController::class, 'verifyOtp'])
        ->name('verifyOtp');

    // Authenticated candidate routes
    Route::middleware('auth:candidate')->group(function () {
        Route::get('/dashboard', function () {
            return view('candidate.dashboard');
        })->name('dashboard');

        Route::post('/logout', [CandidateAuthController::class, 'logout'])
            ->name('logout');
    });
});

/*
|--------------------------------------------------------------------------
| Include Laravel Breeze / Jetstream auth scaffolding (Admin login)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
