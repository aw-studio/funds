<?php

use Funds\Campaign\Http\Middleware\EnsureCampaignMiddleware;
use Funds\Donations\Http\Controllers\CheckoutController;
use Funds\Donations\Http\Controllers\DonationController;
use Funds\Donations\Http\Controllers\DonationIntentController;
use Funds\Donations\Http\Controllers\DonationReceiptAddressController;
use Funds\Donations\Http\Controllers\DonationReceiptController;
use Funds\Donations\Http\Controllers\StripeWebhookController;
use Illuminate\Support\Facades\Route;

Route::app(function () {
    Route::resource('donations', DonationController::class)->only(['index', 'show', 'create', 'store'])
        ->middleware(EnsureCampaignMiddleware::class);

    Route::get('intents', [DonationIntentController::class, 'index'])
        ->name('donations.intents.index')
        ->middleware(EnsureCampaignMiddleware::class);

    Route::get('intents/{intent}', [DonationIntentController::class, 'show'])
        ->name('donations.intents.show')
        ->middleware(EnsureCampaignMiddleware::class);

    Route::get('donations/{donation}/receipt', DonationReceiptController::class)
        ->name('donations.receipt')
        ->middleware(EnsureCampaignMiddleware::class);

    Route::get('donations/{donation}/receipt-address/edit', [DonationReceiptAddressController::class, 'edit'])
        ->name('donations.receipt-address.edit')
        ->middleware(EnsureCampaignMiddleware::class);

    Route::put('donations/{donation}/receipt-address/update', [DonationReceiptAddressController::class, 'update'])
        ->name('donations.receipt-address.update')
        ->middleware(EnsureCampaignMiddleware::class);
});

// Public
Route::group([
    'middleware' => ['web'],
], function () {
    Route::get('c/{campaign}/donate/{reward?}', [CheckoutController::class, 'show'])->name('public.checkout');
    Route::post('c/{campaign}/donate/{reward?}', [CheckoutController::class, 'store'])->name('public.checkout.store');
    Route::get('c/{campaign}/checkout/return/{donationIntent}', [CheckoutController::class, 'return'])->name('public.checkout.return');
});

Route::group([
    'middleware' => ['api'],
],
    function () {
        Route::post('webhook', StripeWebhookController::class)->name('stripe.webhook');
    }
);
