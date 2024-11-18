<?php

use Funds\Foundation\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::app(function () {
    Route::singleton('settings', SettingsController::class)->only('show', 'update');
});

Route::group(['middleware' => 'web'], function () {
    Route::view('/imprint', 'funds::public.pages.imprint')->name('pages.imprint');
    Route::view('/privacy', 'funds::public.pages.privacy')->name('pages.privacy');
    Route::view('/terms', 'funds::public.pages.terms')->name('pages.terms');
});
