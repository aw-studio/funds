<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('guest')->group(function () {
    if (config('funds.registration_enabled')) {
        Volt::route('app/register', 'pages.auth.register')
            ->name('register');
    }

    Volt::route('app/login', 'pages.auth.login')
        ->name('login');

    Volt::route('app/forgot-password', 'pages.auth.forgot-password')
        ->name('password.request');

    Volt::route('app/reset-password/{token}', 'pages.auth.reset-password')
        ->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Volt::route('app/verify-email', 'pages.auth.verify-email')
        ->name('verification.notice');

    Route::get('app/verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Volt::route('app/confirm-password', 'pages.auth.confirm-password')
        ->name('password.confirm');
});
