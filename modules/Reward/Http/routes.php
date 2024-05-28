<?php

use Funds\Campaign\Http\Middleware\EnsureCampaignMiddleware;
use Funds\Reward\Http\Controllers\RewardController;
use Illuminate\Support\Facades\Route;

Route::app(function () {
    Route::resource('rewards', RewardController::class)->only(['index', 'create', 'show', 'store', 'update', 'destroy'])
        ->middleware(EnsureCampaignMiddleware::class);
});
