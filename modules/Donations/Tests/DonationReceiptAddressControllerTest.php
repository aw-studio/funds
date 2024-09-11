<?php

use Funds\Donations\Models\Donation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);
test('It shows an edit form for the donations receipt adress', function () {
    Donation::factory()->withReceiptAddress([
        'address' => 'Teststreet 123',
    ])->create();

    actingAsUser();

    $this->withoutExceptionHandling();
    $response = $this->get(route('donations.receipt-address.edit', Donation::first()));
    expect($response)->status()->toBe(200);
    $response->assertSee('Teststreet 123');
});

test('It updates the donations receipt address', function () {
    $donation = Donation::factory()->withReceiptAddress([
        'address' => 'Teststreet 123',
    ])->create();

    actingAsUser();

    $response = $this->put(route('donations.receipt-address.update', $donation), [
        ...$donation->receipt_address,
        'address' => 'Teststreet 456',
    ]);

    expect($response)->status()->toBe(302);
    expect($donation->fresh()->receipt_address['address'])->toBe('Teststreet 456');
});
