<?php

use Funds\Campaign\Http\Controller\PublicCampaignController;
use Illuminate\Support\Facades\Route;

// Route::get('c/{campaign}', function (\Funds\Campaign\Models\Campaign $campaign) {
//     return redirect()->route('campaigns.public.show', ['campaign' => $campaign]);
// });

Route::get('campaign/{campaign:slug}', [PublicCampaignController::class, 'show'])
    ->name('campaigns.public.show')
    ->missing(fn () => response()->view('public::404', [], 404));
Route::get('campaign/{campaign:slug}/rewards', [PublicCampaignController::class, 'rewards'])->name('campaigns.public.rewards');
