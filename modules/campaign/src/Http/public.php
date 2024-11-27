<?php

use Funds\Campaign\Http\Controller\PublicCampaignController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicCampaignController::class, 'index'])
    ->name('campaigns.public.index');

Route::group([
    'middleware' => ['web'],
    'prefix' => config('funds.single_campaign_mode') ? '' : 'campaigns',
], function () {

    Route::get('/', [PublicCampaignController::class, 'index'])
        ->name('campaigns.public.index');

    Route::get('{campaign:slug?}', [PublicCampaignController::class, 'show'])
        ->name('campaigns.public.show')
        ->missing(function () {
            return response()->view('public::404', [], 404);
        });

    Route::get('{campaign:slug}/donate', [PublicCampaignController::class, 'rewards'])->name('campaigns.public.rewards');
});
