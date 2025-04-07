<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\CreditAccountController;
use App\Http\Controllers\CreditTransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\MpesaTransactionController;

use App\Http\Controllers\Admin\AdminDashboardController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('admin')->middleware(['auth', 'is_admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/logs', [AdminLogController::class, 'index'])->name('logs.index');
    Route::get('/settings', [AdminSettingsController::class, 'index'])->name('settings');
    Route::get('/support', [AdminSupportController::class, 'index'])->name('support');
    Route::get('/profile', [AdminProfileController::class, 'show'])->name('profile');
});


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


    // Route::resource('accounts', AccountController::class)->middleware('auth');
Route::middleware(['auth'])->group(function () {
    Route::resource('transactions', TransactionController::class);
});

Route::post('/mpesa/stk-push', [MpesaTransactionController::class, 'stkPush'])->name('mpesa.stk-push');
Route::post('/mpesa/callback', [MpesaTransactionController::class, 'mpesaCallback'])->name('mpesa.callback');


Route::middleware(['auth'])->group(function () {
    // Route to display the user profile
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.profile');

    // Route to update user profile
    Route::put('profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // Route to change user password
    Route::put('profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

    // Route to upload profile picture
    Route::post('profile/upload-picture', [ProfileController::class, 'updateProfilePicture'])->name('profile.upload-picture');
});


// Route::resource('accounts', AccountController::class)->middleware('auth');
Route::middleware(['auth'])->group(function () {
    Route::resource('accounts', AccountController::class);
});

// Route::resource('accounts', AccountController::class)->middleware('auth');
Route::middleware(['auth'])->group(function () {
    Route::resource('budgets', BudgetController::class);
});

// Route::resource('accounts', AccountController::class)->middleware('auth');
Route::middleware(['auth'])->group(function () {
    Route::resource('credit_accounts', CreditAccountController::class);
});

// Route::resource('accounts', AccountController::class)->middleware('auth');
Route::middleware(['auth'])->group(function () {
    Route::resource('credit_transactions', CreditTransactionController::class);
});

// Route::resource('accounts', AccountController::class)->middleware('auth');
Route::middleware(['auth'])->group(function () {
    Route::resource('reports', ReportController::class);
});


Route::middleware(['auth'])->group(function () {
    Route::get('/support', [SupportController::class, 'create'])->name('support.create');
    Route::post('/support', [SupportController::class, 'store'])->name('support.store');
});


require __DIR__.'/auth.php';
