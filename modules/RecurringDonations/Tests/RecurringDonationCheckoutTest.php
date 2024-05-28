<?php

use Funds\Campaign\Models\Campaign;
use Funds\Donations\Models\DonationIntent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Stripe\Stripe;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('Donation intent is created when submitting a donation', function () {
    $campaign = Campaign::factory()->create();

    $this->withoutExceptionHandling();
    $response = $this->post(route('public.checkout.store', $campaign), [
        'donation_type' => 'recurring',
        'amount' => 100,
        'email' => 'foo@bar.com',
        'iban' => 'DE89370400440532013000',
    ]);

    expect(DonationIntent::count())->toBe(1);
    expect(DonationIntent::first()->payment_intent)->toBeNull(); // no stripe
});
