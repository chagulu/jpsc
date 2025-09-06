<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JetApplicationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ApplicantController;
 use App\Http\Controllers\PaymentController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
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
   Route::get('/applicants', [ApplicantController::class, 'index'])->name('applicants.index');
});

/*
|--------------------------------------------------------------------------
| JET Application Public Form Routes
|--------------------------------------------------------------------------
|
| These routes expose a public JET application form. 
| The GET route shows the form and the POST route handles form submission.
| Throttle middleware limits submissions to 5 per minute to prevent abuse.
|
*/

// Show the JET application form
Route::get('/jet-application', [JetApplicationController::class, 'showForm'])
    ->name('jet.application.form');

// Handle the JET application form submission
Route::post('/jet-application', [JetApplicationController::class, 'submitForm'])
    ->name('jet.application.submit')
    ->middleware('throttle:5,1'); // Limit: 5 submissions per minute

Route::get('/payment-summary/{id}', [JetApplicationController::class, 'summary'])
     ->name('payment.summary');

    

Route::get('payment/summary/{application}', [PaymentController::class, 'summary'])->name('payment.summary');
Route::post('payment/initiate/{application}', [PaymentController::class, 'initiate'])->name('payment.initiate');
Route::post('payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');




    

// Include authentication routes (Laravel Breeze / Jetstream)
require __DIR__.'/auth.php';
