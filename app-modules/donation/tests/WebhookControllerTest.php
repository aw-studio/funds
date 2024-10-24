<?php

use Funds\Donation\Enums\DonationIntentStatus;
use Funds\Donation\Models\Donation;
use Funds\Donation\Models\DonationIntent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);
test('It updates the donation intent if the payment intent succeeded', function () {
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

    expect($donationIntent->refresh()->status)->toBe(DonationIntentStatus::Succeeded);
    expect(Donation::count())->toBe(1);
});

test('It doesnt update a donation intent if the payment intent succeeded with a different id', function () {
    $donationIntent = DonationIntent::factory()->create([
        'payment_intent' => 'testID',
        'status' => 'pending',
    ]);

    $this->postJson(route('stripe.webhook'), [
        'type' => 'payment_intent.succeeded',
        'data' => [
            'object' => [
                'id' => 'anotherId',
            ],
        ],
    ])->assertOk();

    expect($donationIntent->refresh()->status)->toBe(DonationIntentStatus::Pending);
    expect(Donation::count())->toBe(0);
});

test('It updates the donation intent status if the payment intent failed', function () {

    $donationIntent = DonationIntent::factory()->create([
        'payment_intent' => 'testID',
    ]);

    $this->postJson(route('stripe.webhook'), [
        'type' => 'payment_intent.payment_failed',
        'data' => [
            'object' => [
                'id' => $donationIntent->payment_intent,
            ],
        ],
    ])->assertOk();

    expect($donationIntent->refresh()->status)->toBe(DonationIntentStatus::Failed);
    expect(Donation::count())->toBe(0);
});
