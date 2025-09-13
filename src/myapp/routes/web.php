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
| 1) Open / public routes
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => redirect()->route('candidate.login'));

// 2FA (admin login flow)
Route::get('/2fa', [TwoFactorController::class, 'showForm'])->name('2fa.verify.form');
Route::post('/2fa', [TwoFactorController::class, 'verifyOtp'])->name('2fa.verify');

// JET public application routes
Route::get('/jet-application', [JetApplicationController::class, 'showForm'])
    ->name('jet.application.form');
Route::post('/jet-application', [JetApplicationController::class, 'submitForm'])
    ->middleware('throttle:5,1')
    ->name('jet.application.submit');
Route::put('/jet-application/{application}', [JetApplicationController::class, 'updateForm'])
    ->name('jet.application.update');

// Payment endpoints
Route::get('/payment/summary/{application}', [PaymentController::class, 'summary'])->name('payment.summary');
Route::post('/payment/initiate/{application}', [PaymentController::class, 'initiate'])->name('payment.initiate');
Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');

// OTP endpoints
Route::post('/send-otp', [JetApplicationController::class, 'sendOtp'])->name('otp.send');
Route::post('/verify-otp', [JetApplicationController::class, 'verifyOtp'])->name('otp.verify');

/*
|--------------------------------------------------------------------------
| 2) Candidate authentication routes
|--------------------------------------------------------------------------
*/
Route::prefix('candidate')->name('candidate.')->group(function () {

    // Login page
Route::get('/login', function () {
    if (Auth::guard('candidate')->check()) {
        // Candidate is already logged in → redirect to dashboard
        return redirect()->route('candidate.dashboard');
    }
    // Otherwise, show login page
        return view('candidate.login');
    })->name('login');

    // OTP login
    Route::post('/request-otp', [CandidateAuthController::class, 'requestOtp'])->name('requestOtp');
    Route::post('/verify-otp', [CandidateAuthController::class, 'verifyOtp'])->name('verifyOtp');

    // Protected candidate routes using auth.candidate middleware
    Route::middleware(['auth.candidate'])->group(function () {

       Route::get('/dashboard', [JetApplicationController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [JetApplicationController::class, 'applicationProfile'])->name('profile');
        Route::get('/upload-documents/{application_id}', [JetApplicationController::class, 'uploadDocuments'])->name('uploadDocuments');
        Route::post('/upload-documents/{application_id}', [JetApplicationController::class, 'uploadDocumentsStore'])->name('uploadDocumentsStore');
        Route::get('/other-details/{application_id}', [JetApplicationController::class, 'otherDetails'])->name('otherDetails');
        Route::post('/other-details/{application_id}', [JetApplicationController::class, 'otherDetailsStore'])->name('otherDetailsStore');
        Route::get('/education/{application_id}', [JetApplicationController::class, 'education'])->name('education');
        Route::post('/education/{application_id}', [JetApplicationController::class, 'educationStore'])->name('educationStore');
        Route::get('/preview/{application_id}', [JetApplicationController::class, 'preview'])->name('preview');
        Route::post('/preview/{application_id}', [JetApplicationController::class, 'previewStore'])->name('previewStore');
        Route::get('/completed', [JetApplicationController::class, 'completed'])->name('completed');
        Route::post('/completed/{application_id}', [JetApplicationController::class, 'completedStore'])->name('completedStore');

        // Candidate logout
        Route::post('/logout', [CandidateAuthController::class, 'logout'])->name('logout');
    });
});

// Candidate-protected routes outside /candidate
Route::middleware(['auth.candidate'])->group(function () {
    Route::get('/profile-summary', [JetApplicationController::class, 'profileSummary'])->name('profile.summary');
    Route::get('/candidate-application', [JetApplicationController::class, 'candidatedDashboardApplication'])->name('application');
    Route::get('/get-profile-summary', [JetApplicationController::class, 'getProfileSummary'])->name('profile.summary.save');
});

/*
|--------------------------------------------------------------------------
| 3) Admin authentication routes
|--------------------------------------------------------------------------
| Uses default 'web' guard and verified middleware
*/
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    // Admin profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin application listing
    Route::get('/admin/applications', [ApplicationSearchController::class, 'index'])->name('admin.applications.index');
    Route::get('/applications/{id}', [App\Http\Controllers\Admin\ApplicationController::class, 'show'])->name('admin.applications.show');

});

/*
|--------------------------------------------------------------------------
| Breeze / Jetstream default auth
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
