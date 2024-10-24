<?php

use Funds\Donation\Models\Donation;
use Funds\Donation\Models\DonationCollection;
use Funds\Foundation\Support\Amount;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);
test('A donation may have an order of a reward', function () {
    $donations = Donation::factory()->count(5)->create(['amount' => 100]);
    expect($donations)->count()->toBe(5);
    expect($donations)->toBeInstanceOf(DonationCollection::class);
    expect($donations->totalAmount())->toBeInstanceOf(Amount::class);
    expect($donations->totalAmount()->get())->toBe(500);
});
