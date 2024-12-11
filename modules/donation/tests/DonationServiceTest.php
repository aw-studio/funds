<?php

use Funds\Campaign\Models\Campaign;
use Funds\Donation\DTOs\DonationIntentDto;
use Funds\Donation\Models\Donation;
use Funds\Donation\Models\Donor;
use Funds\Donation\Services\DonationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);
test('createDonationFromIntent creates a donation and associates it with a donor and campaign', function () {
    // Arrange
    $intentData = new DonationIntentDto(
        id: '1',
        name: 'User',
        email: 'foo@bar.com',
        amount: 1000,
        type: 'one_time',
        paysFees: false,
        campaignId: Campaign::factory()->create()->id,
        receiptAddress: null,
        // receiptAddress: ['name' => 'User foo', 'address' => '123 Main St', 'city' => 'Anytown', 'state' => 'NY', 'postal_code' => '12345', 'country' => 'US'],
        donationId: null,
        orderDetails: null
    );

    $service = new DonationService;

    $result = $service->createDonationFromIntent($intentData);
    expect(Donation::count())->toBe(1);
    expect($result)->toBeInstanceOf(Donation::class);
});

test('It saves the receipt address if given', function () {
    $intentData = new DonationIntentDto(
        id: '1',
        name: 'User',
        email: 'user@test.com',
        amount: 1000,
        type: 'one_time',
        paysFees: false,
        campaignId: Campaign::factory()->create()->id,
        receiptAddress: ['name' => 'User foo', 'street' => '123 Main St', 'city' => 'Anytown', 'state' => 'NY', 'postal_code' => '12345', 'country' => 'US'],
        donationId: null,
        orderDetails: null
    );

    $service = new DonationService;
    $result = $service->createDonationFromIntent($intentData);

    expect($result->receipt_address)->toBe($intentData->receiptAddress);

});

test('findOrCreateDonor finds an existing donor or creates a new one', function () {

    expect(Donor::count())->toBe(0);

    $email = 'donor@example.com';
    $name = 'John Doe';
    $service = new DonationService;
    $result = $service->findOrCreateDonor($email, $name);

    expect(Donor::count())->toBe(1);
    expect($result)->toBeInstanceOf(Donor::class);
    expect($result->email)->toBe($email);
    expect($result->name)->toBe($name);
});
