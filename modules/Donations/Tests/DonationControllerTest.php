<?php

use Funds\Donations\Models\Donation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);
test('It renders a list of donation completed donations', function () {

    actingAsUser();
    $donations = Donation::factory()
        ->for(auth()->user()->currentCampaign)
        ->count(10)
        ->create();
    $response = $this->get(route('donations.index'));

    $response->assertViewIs('donations::index');
    // $response->assertViewHas('donations', $donations);
    // expect($response)->viewData('donations')->count()->toBe(10);
});
