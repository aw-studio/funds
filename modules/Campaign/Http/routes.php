<?php

use Funds\Campaign\Http\Controller\API\CampaignApiController;
use Funds\Campaign\Http\Controller\CampaignController;
use Funds\Campaign\Http\Controller\PublicCampaignController;
use Illuminate\Support\Facades\Route;

// App
Route::app(function () {
    Route::get('campaigns', [CampaignController::class, 'index'])->name('campaigns.index');
    Route::get('campaigns/create', [CampaignController::class, 'create'])->name('campaigns.create');
    Route::post('campaigns', [CampaignController::class, 'store'])->name('campaigns.store');
    Route::get('campaigns/{campaign}', [CampaignController::class, 'show'])->name('campaigns.show');
});

// Api
Route::group([
    'middleware' => ['api'],
], function () {
    Route::get('/campaign/{campaign}', [CampaignApiController::class, 'show'])->name('campaigns.api.show');
});

// Public
Route::group([
    'middleware' => ['web'],
], function () {
    Route::get('c/{id}', [PublicCampaignController::class, 'show'])->name('public.campaigns.show');
});
