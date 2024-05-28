<?php

use Funds\Campaign\Models\Campaign;
use Funds\Donations\Models\Donation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('A campaign has a name', function () {
    $campaign = Campaign::factory()->create([
        'name' => 'Test Campaign',
    ]);
    Donation::factory();
    expect($campaign->name)->toBe('Test Campaign');
});

test('A campaign has a description');

test('A campaign has a goal');

test('A campaign can be published');

test('A campaign can have faqs');

test('A campaign can have rewards');

test('A campaign has a story');
// test('A campaign can have style settings');
