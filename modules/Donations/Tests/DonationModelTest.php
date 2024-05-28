<?php

use Funds\Core\Support\Amount;
use Funds\Donations\Models\Donation;
use Funds\Donations\Models\Donor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);
test('It has an amount', function () {
    $donation = new Donation([
        'amount' => 100,
    ]);

    expect($donation->amount)->toBeInstanceOf(Amount::class);
    expect($donation->amount->get())->toBe(100);
});

test('It belongs to a donor', function () {
    $donation = Donation::factory()->create();

    expect($donation->donor)->toBeInstanceOf(Donor::class);
});
