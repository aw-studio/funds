<?php

use Funds\Campaign\Http\Middleware\EnsureCampaignMiddleware;
use Funds\Reward\Http\Controllers\RewardController;
use Funds\Reward\Http\Controllers\RewardVariantController;
use Illuminate\Support\Facades\Route;

Route::app(function () {
    Route::resource('rewards', RewardController::class)->only(['index', 'create', 'show', 'edit', 'store', 'update', 'destroy'])
        ->middleware(EnsureCampaignMiddleware::class);

    Route::resource('rewards.variants', RewardVariantController::class)->only(['store', 'destroy'])
        ->middleware(EnsureCampaignMiddleware::class);
});
