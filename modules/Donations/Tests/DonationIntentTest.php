<?php

use Funds\Donations\Events\DonationIntentSucceeded;
use Funds\Donations\Models\Donation;
use Funds\Donations\Models\DonationIntent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);
test('A DonationIntent', function () {

    $intent = DonationIntent::factory()->create([
        'email' => 'user@bar.com',
    ]);

    expect($intent->email)->toBe('user@bar.com');

});

test('Finalizing a DonationIntent creates a Donation', function () {

    $intent = DonationIntent::factory()->create();
    $intent->succeed();

    expect($intent->status)->toBe('succeeded');
    expect($intent->donation)->toBeInstanceOf(Donation::class);
});

test('Finalizing a DonationIntent fires the DonationIntentFinalized event', function () {

    Event::fake();
    $intent = DonationIntent::factory()->create();
    $intent->succeed();

    Event::assertDispatched(DonationIntentSucceeded::class);
});
