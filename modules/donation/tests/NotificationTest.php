<?php

use Funds\Donation\Models\DonationIntent;
use Funds\Donation\Notifications\DonationReceivedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('The donor receives a notification if the donation succeed', function () {

    Notification::fake();

    $intent = DonationIntent::factory()->create([
        'email' => 'user@bar.com',
    ]);

    $intent->succeed();

    Notification::assertSentTo(
        $intent->donation->donor,
        DonationReceivedNotification::class
    );

});
