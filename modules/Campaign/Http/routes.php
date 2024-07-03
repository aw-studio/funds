<?php

use Funds\Campaign\Http\Controller\API\CampaignApiController;
use Funds\Campaign\Http\Controller\CampaignContentController;
use Funds\Campaign\Http\Controller\CampaignController;
use Funds\Campaign\Http\Controller\PublicCampaignController;
use Funds\Campaign\Models\Campaign;
use Illuminate\Support\Facades\Route;

// App
Route::app(function () {
    Route::resource('campaigns', CampaignController::class);
    Route::get('campaigns/{campaign}/content', [CampaignContentController::class, 'edit'])->name('campaigns.content.edit');
    Route::post('campaigns/{campaign}/content', [CampaignContentController::class, 'update'])->name('campaigns.content.store');
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

    Route::get('c/{campaign}', function (\Funds\Campaign\Models\Campaign $campaign) {
        return redirect()->route('public.campaigns.show', ['campaign' => $campaign]);
    });

    Route::get('campaign/{campaign:slug}', [PublicCampaignController::class, 'show'])->name('public.campaigns.show');
});
