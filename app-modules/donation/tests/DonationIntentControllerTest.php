<?php

use Funds\Donation\Models\DonationIntent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);
test('It renders a list of donation intents', function () {
    DonationIntent::factory()->create([
        'email' => 'test@test.com',
    ]);

    actingAsUser();

    $response = $this->get(route('donations.intents.index'));
    expect($response)->status()->toBe(200);
    $response->assertSee('test@test.com');
});
