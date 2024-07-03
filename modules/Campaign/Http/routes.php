<?php

use Funds\Campaign\Http\Controller\API\CampaignApiController;
use Funds\Campaign\Http\Controller\CampaignController;
use Funds\Campaign\Http\Controller\PublicCampaignController;
use Illuminate\Support\Facades\Route;

// App
Route::app(function () {

    Route::resource('campaigns', CampaignController::class);
});

// Api
Route::group([
    'middleware' => ['api'],
], function () {
    // Route::get('/campaign/{campaign}', [CampaignApiController::class, 'show'])->name('campaigns.api.show');
});

// Public
Route::group([
    'middleware' => ['web'],
], function () {
    Route::get('c/{campaign}', [PublicCampaignController::class, 'show'])->name('public.campaigns.show');
});
