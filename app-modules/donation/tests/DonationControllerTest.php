<?php

use Funds\Donation\Models\Donation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);
test('It renders a list of donation completed donations', function () {

    actingAsUser();
    $donations = Donation::factory()
        ->for(auth()->user()->currentCampaign)
        ->count(10)
        ->create();
    $response = $this->get(route('donations.index'));

    $response->assertViewIs('donation::index');
    // $response->assertViewHas('donations', $donations);
    // expect($response)->viewData('donations')->count()->toBe(10);
});

test('An authenticated user can view the donation creation form', function () {

    actingAsUser();

    $response = $this->get(route('donations.create'));

    $response->assertViewIs('donation::create');
});

test('An authenticated user can add a new donation', function () {

    actingAsUser();

    $this->withoutExceptionHandling();
    $response = $this->post(route('donations.store'), [
        'email' => 'foo@bar.com',
        'amount' => 100,
    ]);

    expect(Donation::count())->toBe(1);
});

test('An authenticated user can view a donation', function () {

    actingAsUser();

    $donation = Donation::factory()
        ->for(auth()->user()->currentCampaign)
        ->create();

    $this->withoutExceptionHandling();
    $response = $this->get(route('donations.show', $donation));

    $response->assertViewIs('donation::show');
    $response->assertViewHas('donation', $donation);
    $response->assertViewHas('donor', $donation->donor);
});
