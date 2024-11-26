<?php

use Funds\Foundation\Http\Controllers\LegalPageController;
use Funds\Foundation\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::app(function () {
    Route::singleton('settings', SettingsController::class)->only('show', 'update');
});

Route::group(['middleware' => 'web'], function () {
    Route::get('/pages/{page}', LegalPageController::class)->name('public.legalpage');
});
