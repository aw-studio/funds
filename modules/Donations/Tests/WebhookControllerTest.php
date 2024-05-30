<?php

use Funds\Donations\Models\Donation;
use Funds\Donations\Models\DonationIntent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);
test('It updates an order if an async payment succeeded', function () {

    $donationIntent = DonationIntent::factory()->create([
        'payment_intent' => 'testID',
    ]);

    $this->withoutExceptionHandling();
    $this->postJson(route('stripe.webhook'), [
        'type' => 'payment_intent.succeeded',
        'data' => [
            'object' => [
                'id' => $donationIntent->payment_intent,
            ],
        ],
    ])->assertOk();

    expect($donationIntent->refresh()->status)->toBe('succeeded');
    expect(Donation::count())->toBe(1);
});
