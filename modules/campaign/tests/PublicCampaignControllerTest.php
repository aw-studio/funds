<?php

use App\Models\User;
use Funds\Campaign\Models\Campaign;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('An unpublished campaign cant be viewed publically', function () {
    config(['funds.single_campaign_mode' => false]);
    $campaign = Campaign::factory([])->create();
    $response = $this->get(route('campaigns.public.show', $campaign));

    $response->assertViewIs('public::404');
});

test('A published campaign can be viewed publically', function () {
    config(['funds.single_campaign_mode' => false]);

    $campaign = Campaign::factory([
        'published_at' => now(),
    ])->create();

    $response = $this->get(route('campaigns.public.show', $campaign));

    $response->assertViewIs('campaign::public.show');
    $response->assertViewHas('campaign', $campaign);
});

test('A published campaign will redirect to root in single_campaign_mode', function () {
    config(['funds.single_campaign_mode' => true]);

    $campaign = Campaign::factory([
        'published_at' => now(),
    ])->create();

    $response = $this->get(route('campaigns.public.show', $campaign));

    $response->assertRedirect(route('campaigns.public.index'));
});

test('An authenticated user can view a campaign in single_campaign_mode', function () {
    config(['funds.single_campaign_mode' => true]);

    $campaign = Campaign::factory([
        'published_at' => now(),
    ])->create();

    $response = $this->actingAs(User::factory()->create())->get(route('campaigns.public.show', $campaign));

    $response->assertViewIs('campaign::public.show');
    $response->assertViewHas('campaign', $campaign);
});
