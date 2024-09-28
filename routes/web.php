<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecoveryTwoFactorAuthController;
use App\Http\Controllers\TwoFactorAuthController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\VerifyEmailController;
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

// 2FA login with recovery codes
Route::get('two-factor/recovery-codes/forgot', [RecoveryTwoFactorAuthController::class, 'showForgot'])->name('two-factor.recovery-codes.forgot');
Route::post('two-factor/recovery-codes/process', [RecoveryTwoFactorAuthController::class, 'processForgot'])->name('two-factor.recovery-codes.process');

Route::middleware(['auth', 'verified'])->group(function () {
    // home
    Route::get('home', [HomeController::class, 'index'])->name('home.index');

    // 2FA
    Route::post('two-factor-enable', [TwoFactorAuthController::class, 'enable'])->name('two-factor.enable');
    Route::post('two-factor-confirm', [TwoFactorAuthController::class, 'confirm'])->name('two-factor.confirm');
    Route::delete('two-factor-delete', [TwoFactorAuthController::class, 'destroy'])->name('two-factor.delete');
    // 2FA recovery codes
    Route::get('two-factor/recovery-codes', [TwoFactorAuthController::class, 'recoveryCodes'])->name('two-factor.recovery-codes.index');
    Route::post('two-factor/recovery-codes', [TwoFactorAuthController::class, 'generateRecoveryCodes'])->name('two-factor.recovery-codes.generate');

    // profile
    Route::put('profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

});

// Mendefinisikan rute untuk verifikasi email dengan middleware 'auth', 'signed', dan 'throttle'
Route::get('email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');
