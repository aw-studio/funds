<?php

use Funds\Donations\Models\DonationIntent;
use Funds\RecurringDonations\Models\RecurringDonationIntent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('A donation intent with type recurring is a recurring donation intent', function () {
    DonationIntent::factory()->create([
        'type' => 'recurring',
    ]);

    expect(RecurringDonationIntent::count())->toBe(1);
});
