<?php

use Funds\Campaign\Http\Controller\API\CampaignApiController;
use Funds\Campaign\Http\Controller\CampaignContentController;
use Funds\Campaign\Http\Controller\CampaignController;
use Funds\Campaign\Models\Campaign;
use Illuminate\Support\Facades\Route;

// App
Route::app(function () {
    Route::resource('campaigns', CampaignController::class);
    Route::get('campaign-create', [CampaignController::class, 'create']);

    Route::get('campaigns/{campaign}/content', [CampaignContentController::class, 'edit'])->name('campaigns.content.edit');
    Route::post('campaigns/{campaign}/content', [CampaignContentController::class, 'update'])->name('campaigns.content.store');
    Route::post('campaigns/{campaign}/content/upload-image', [CampaignContentController::class, 'uploadImage'])->name('campaigns.content.upload-image');
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

    require __DIR__.'/public.php';
});
