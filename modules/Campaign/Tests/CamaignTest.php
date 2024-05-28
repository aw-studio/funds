<?php

use App\Models\User;
use Funds\Campaign\Enum\CampaignStatus;
use Funds\Campaign\Models\Campaign;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('A user can see a list of campaigns', function () {
    $campaign = Campaign::factory()->create([
        'name' => 'Test Campaign',
    ]);

    $response = $this->actingAs(User::factory()->create())
        ->get('app/campaigns');

    $response->assertSee('Test Campaign');
});

test('A user can create a campaign', function () {
    $this->actingAs(User::factory()->create())
        ->post('app/campaigns', [
            'name' => 'Test Campaign',
            'goal' => 1000,
        ]);

    expect(Campaign::where('name', 'Test Campaign')->exists())->toBeTrue();
});

test('A new campaign is a draft by default', function () {
    $this->actingAs(User::factory()->create())
        ->post('app/campaigns', [
            'name' => 'Test Campaign',
            'goal' => 1000,
        ]);

    $campaign = Campaign::where('name', 'Test Campaign')->first();

    expect($campaign->status)->toBe(CampaignStatus::Draft);
});

test('A user can see a campaign', function () {
    $campaign = Campaign::factory()->create([
        'name' => 'Test Campaign',
    ]);

    $response = $this->actingAs(User::factory()->create())
        ->get('app/campaigns/'.$campaign->id);

    $response->assertSee('Test Campaign');
});
