<?php

use Funds\Campaign\Http\Middleware\EnsureCampaignMiddleware;
use Funds\Donation\Http\Controllers\CheckoutController;
use Funds\Donation\Http\Controllers\DonationController;
use Funds\Donation\Http\Controllers\DonationIntentController;
use Funds\Donation\Http\Controllers\DonationReceiptAddressController;
use Funds\Donation\Http\Controllers\DonationReceiptController;
use Funds\Donation\Http\Controllers\DonorController;
use Funds\Donation\Http\Controllers\StripeWebhookController;
use Funds\Donation\Notifications\DonationReceivedNotification;
use Illuminate\Support\Facades\Route;

Route::app(function () {
    Route::resource('donations', DonationController::class)->only(['index', 'show', 'create', 'store'])
        ->middleware(EnsureCampaignMiddleware::class);

    Route::resource('donors', DonorController::class)->only(['edit', 'update']);

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
    Route::get('{campaign:slug}/donate/checkout/{reward:slug?}', [CheckoutController::class, 'show'])->name('public.checkout');
    Route::post('{campaign:slug}/donate/checkout/{reward?}', [CheckoutController::class, 'store'])->name('public.checkout.store');
    Route::get('{campaign:slug}/donate/checkout/return/{donationIntent}', [CheckoutController::class, 'return'])->name('public.checkout.return');
});

Route::get('test/notification/{id?}', function () {

    if (app()->environment('production')) {
        abort(404);
    }

    $id = request()->route('id');
    $donation = \Funds\Donation\Models\Donation::findOr($id, function () {
        return \Funds\Donation\Models\Donation::first();
    });

    try {
        $donation->donor->notify(new DonationReceivedNotification($donation));
    } catch (Exception $e) {
        dump($e->getMessage());
    }

    return (new DonationReceivedNotification($donation))
        ->toMail($donation->donor);
});

Route::group([
    'middleware' => ['api'],
],
    function () {
        Route::post('webhook', StripeWebhookController::class)->name('stripe.webhook');
    }
);
