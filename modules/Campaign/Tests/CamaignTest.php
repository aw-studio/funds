<?php

use App\Models\User;
use Funds\Campaign\Enum\CampaignStatus;
use Funds\Campaign\Models\Campaign;
use Funds\Donations\Models\Donation;
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
    $response = $this->actingAs(User::factory()->create())
        ->post('app/campaigns', [
            'name' => 'Test Campaign',
            'goal' => 1000,
        ]);

    expect(Campaign::where('name', 'Test Campaign')->exists())->toBeTrue();

    expect($response->status())->toBe(302);
});

test('A user can switch to a another campaign', function () {
    $user = User::factory(['current_campaign_id' => null])->create();
    $campaign = Campaign::factory()->create();

    expect($user->current_campaign_id)->toBeNull();
    $user->switchCurrentCampaignTo($campaign);
    expect($user->current_campaign_id)->toBe($campaign->id);
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

test('Accessing a campaign will set the current campaign', function () {
    $campaign = Campaign::factory()->create();

    $user = User::factory([
        'current_campaign_id' => null,
    ])->create();
    expect($user->current_campaign_id)->toBeNull();

    $this->actingAs($user)
        ->get('app/campaigns/'.$campaign->id);

    expect($user->current_campaign_id)->toBe($campaign->id);
});

test('The amount of donations is calculated correctly', function () {
    $campaign = Campaign::factory()->create();
    $donations = Donation::factory()
        ->for($campaign)
        ->count(3)
        ->create([
            'amount' => 200,
        ]);

    expect($campaign->totalAmountDonated()->cents)->toBe(600);
});
