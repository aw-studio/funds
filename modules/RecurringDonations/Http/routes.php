<?php

use Funds\RecurringDonations\Http\Controllers\RecurringDonationController;
use Funds\RecurringDonations\Http\Controllers\RecurringDonationIntentController;
use Illuminate\Support\Facades\Route;

Route::app(function () {
    Route::group(['prefix' => 'recurring-donations'], function () {
        Route::get('/', [RecurringDonationController::class, 'index'])->name('recurring-donations.index');

        Route::get('intents', [RecurringDonationIntentController::class, 'index'])
            ->name('recurring-donations.intents.index');

        Route::post('intents/{intent}/confirm', [RecurringDonationIntentController::class, 'confirm'])
            ->name('recurring-donations.intents.confirm');
    });

});
