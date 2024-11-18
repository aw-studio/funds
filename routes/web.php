<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (config('funds.public_campaign_overview')) {
        return view('welcome');
    }

    return redirect()->route('dashboard');
});
Route::get('/app', fn () => redirect()->route('dashboard'));
Route::redirect('app/dashboard', 'campaigns')->name('dashboard');

Route::view('app/profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
