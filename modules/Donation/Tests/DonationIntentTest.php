<?php

use Funds\Donation\Enums\DonationIntentStatus;
use Funds\Donation\Events\DonationIntentSucceeded;
use Funds\Donation\Models\Donation;
use Funds\Donation\Models\DonationIntent;
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

    $this->withoutExceptionHandling();
    $intent = DonationIntent::factory()->create();
    $intent->succeed();

    expect($intent->status)->toBe(DonationIntentStatus::Succeeded);
    expect(Donation::where('intent_id', $intent->id)->count())->toBe(1);

});

test('Succeeding a DonationIntent twice does not create a new Donation', function () {

    $intent = DonationIntent::factory()->create();
    $intent->succeed();
    $intent->succeed();

    expect($intent->status)->toBe(DonationIntentStatus::Succeeded);
    expect(Donation::where('intent_id', $intent->id)->count())->toBe(1);
});

test('Finalizing a DonationIntent fires the DonationIntentFinalized event', function () {

    Event::fake();
    $intent = DonationIntent::factory()->create();
    $intent->succeed();

    Event::assertDispatched(DonationIntentSucceeded::class);
});

test('A pending DonationIntent can fail', function () {

    $intent = DonationIntent::factory()->create();
    $intent->fail();

    expect($intent->status)->toBe(DonationIntentStatus::Failed);
});

test('A non pending DonationIntent cannot fail', function ($status) {
    $intent = DonationIntent::factory()->create([
        'status' => $status,
    ]);

    $this->expectException(\Exception::class);
    $intent->fail();
})->with([
    'succeeded',
    'failed',
]);

test('A donation intent that has a donation cannot be failed', function () {
    $intent = DonationIntent::factory()->has(Donation::factory())->create();
    $this->expectException(\Exception::class);
    $intent->fail();
});
