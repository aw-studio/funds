<?php

use Illuminate\Support\Facades\Route;

Route::redirect('app/dashboard', 'campaigns')->name('dashboard');

Route::view('app/profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
