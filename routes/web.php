<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (config('funds.public_campaign_overview')) {
        return view('welcome');
    }

    return redirect()->to('app/dashboard');
});
Route::get('/app', fn () => redirect()->to('app/dashboard'));

Route::view('app/dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::redirect('app/dashboard', 'campaigns');

Route::view('app/profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
