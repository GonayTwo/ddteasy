<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Livewire\Web\Auth\ResetLogin;
use Illuminate\Support\Facades\Route;

Route::name('site.auth.')->group(function () {
    Route::get('/cadastro', \App\Livewire\Web\Auth\Register::class)->name('register');
    Route::post('/cadastro', [RegisteredUserController::class, 'store'])
        ->middleware('guest');

    Route::get('/login', \App\Livewire\Web\Auth\Login::class)->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('guest');

    Route::get('/esqueci-minha-senha', \App\Livewire\Web\Auth\ForgotPassword::class)->name('forgot-password');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->middleware('guest')
        ->name('password.email');

    Route::get('/resetar-senha/{token}', ResetLogin::class);
    Route::post('/resetar-senha', [NewPasswordController::class, 'store']);
});

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.store');

Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');
