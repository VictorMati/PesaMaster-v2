<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

    Route::middleware(['auth'])->group(function () {
        Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index'); // List all transactions
        Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show'); // View transaction details
        Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store'); // Create new transaction
        Route::put('/transactions/{transaction}', [TransactionController::class, 'update'])->name('transactions.update'); // Update transaction
        Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy'); // Delete transaction
    });


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
