<?php

use Funds\Campaign\Http\Middleware\EnsureCampaignMiddleware;
use Funds\Donations\Http\Controllers\CheckoutController;
use Funds\Donations\Http\Controllers\DonationController;
use Funds\Donations\Http\Controllers\StripeWebhookController;
use Illuminate\Support\Facades\Route;

Route::app(function () {
    Route::resource('donations', DonationController::class)->only(['index', 'show', 'create', 'store'])
        ->middleware(EnsureCampaignMiddleware::class);
});

// Public
Route::group([
    'middleware' => ['web'],
], function () {
    Route::get('c/{campaign}/donate/{reward?}', [CheckoutController::class, 'show'])->name('public.checkout');
    Route::post('c/{campaign}/donate/{reward?}', [CheckoutController::class, 'store'])->name('public.checkout.store');
    Route::get('c/{campaign}/checkout/return', [CheckoutController::class, 'return'])->name('public.checkout.return');
});

Route::group([
    'middleware' => ['api'],
],
    function () {
        Route::post('webhook', StripeWebhookController::class)->name('stripe.webhook');
    }
);
