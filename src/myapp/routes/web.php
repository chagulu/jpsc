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
|
| These routes are loaded by the RouteServiceProvider within the "web"
| middleware group. Build something great!
|
*/

// Default welcome page
Route::get('/', function () {
    return view('welcome');
});

// Dashboard (requires authentication and email verification)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes for authenticated users (profile management)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // List applicants with filters and pagination
    Route::get('/admin/applications', [ApplicationSearchController::class, 'index'])->name('admin.applications.index');
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
    ->middleware('throttle:5,1'); // Limit: 5 submissions per minute

Route::get('/payment-summary/{id}', [JetApplicationController::class, 'summary'])
    ->name('payment.summary');

Route::get('payment/summary/{application}', [PaymentController::class, 'summary'])->name('payment.summary');
Route::post('payment/initiate/{application}', [PaymentController::class, 'initiate'])->name('payment.initiate');
Route::post('payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');

/*
|--------------------------------------------------------------------------
| Candidate OTP Login Routes
|--------------------------------------------------------------------------
|
| Candidates use email + OTP (no password). We keep these separate from
| default auth using the "candidate" guard defined in config/auth.php
|
*/
Route::prefix('candidate')->name('candidate.')->group(function () {

    // Step 1: Candidate enters email & requests OTP
    Route::get('/login', function () {
        return view('candidate.login');   // Blade form for email/OTP
    })->name('login');

    Route::post('/request-otp', [CandidateAuthController::class, 'requestOtp'])->name('requestOtp');

    // Step 2: Candidate submits OTP to log in
    Route::post('/verify-otp', [CandidateAuthController::class, 'verifyOtp'])->name('verifyOtp');

    // Authenticated candidate routes
    Route::middleware('auth:candidate')->group(function () {
        Route::get('/dashboard', function () {
            return view('candidate.dashboard');
        })->name('dashboard');

        Route::post('/logout', [CandidateAuthController::class, 'logout'])->name('logout');
    });
});

// Include Laravel Breeze / Jetstream auth scaffolding
require __DIR__ . '/auth.php';
