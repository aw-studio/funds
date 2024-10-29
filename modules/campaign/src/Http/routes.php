<?php

use Funds\Campaign\Http\Controller\CamapaignStoryController;
use Funds\Campaign\Http\Controller\CampaignController;
use Funds\Campaign\Http\Controller\CampaignFaqController;
use Funds\Campaign\Http\Controller\CampaignPitchController;
use Funds\Campaign\Http\Controller\CampaignStyleSettingsController;
use Funds\Campaign\Models\Campaign;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

// App
Route::app(function () {
    Route::resource('campaigns', CampaignController::class);

    Route::group([
        'prefix' => 'campaigns/{campaign}/content',
    ], function () {
        Route::get('/', function (Campaign $campaign) {
            return redirect()->route('campaigns.content.pitch.edit', $campaign);
        })->name('campaigns.content');

        Route::get('story', [CamapaignStoryController::class, 'edit'])->name('campaigns.content.story.edit');
        Route::post('story', [CamapaignStoryController::class, 'update'])->name('campaigns.content.story.update');
        Route::post('story/upload-image', [CamapaignStoryController::class, 'uploadImage'])->name('campaigns.content.story.upload-image');

        Route::get('pitch', [CampaignPitchController::class, 'edit'])->name('campaigns.content.pitch.edit');
        Route::post('pitch', [CampaignPitchController::class, 'store'])->name('campaigns.content.pitch.store');

        Route::get('faqs', [CampaignFaqController::class, 'edit'])->name('campaigns.content.faqs.edit');
        Route::post('faqs', [CampaignFaqController::class, 'update'])->name('campaigns.content.faqs.update');

        Route::get('design-settings', [CampaignStyleSettingsController::class, 'edit'])->name('campaigns.content.style-settings.edit');
        Route::post('design-settings', [CampaignStyleSettingsController::class, 'update'])->name('campaigns.content.style-settings.update');

    });

});

// Route::name('foo.')->group(function () {
//     Route::get('design', function () {
//         dump(request()->route()->getName());
//         dump(Request::is('foo'));
//     })->name('design');
//     // Route::get('design', [CampaignStyleSettingsController::class, 'edit'])->name('campaigns.style-settings.edit');
// });

// // Api
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
