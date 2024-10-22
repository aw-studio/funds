<?php

use Funds\Campaign\Models\Campaign;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('A published campaign can be viewed publically ', function () {
    $campaign = Campaign::factory()->create();
    $response = $this->get(route('campaigns.public.show', $campaign));

    $response->assertViewIs('campaigns::public.show');
    $response->assertViewHas('campaign', $campaign);
});
