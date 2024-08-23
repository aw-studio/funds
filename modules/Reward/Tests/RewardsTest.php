<?php

use App\Models\User;
use Funds\Core\Support\Amount;
use Funds\Reward\Models\Reward;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use function Pest\Laravel\actingAs;

uses(TestCase::class, RefreshDatabase::class);
test('A user can view rewards', function () {
    $response = actingAsUser()
        ->get('app/rewards');
    $response->assertStatus(200);
});

test('It lists all rewards', function () {
    actingAsUser();

    Reward::factory()->count(3)->create([
        'campaign_id' => auth()->user()->current_campaign_id,
    ]);

    $response = $this->get('app/rewards');
    expect($response->viewData('rewards'))->toHaveCount(3);
});

test('It renders a form to create a new reward', function () {
    $response = actingAsUser()
        ->get('app/rewards/create');
    $response->assertStatus(200);
});

test('A user can create rewards', function () {
    actingAsUser()
        ->post('app/rewards', [
            'reward_name' => 'New Reward',
            'description' => 'This is a new reward',
            'min_amount' => 100,
        ]);
    expect(Reward::count())->toBe(1);
    $reward = Reward::first();
    expect($reward->name)->toBe('New Reward');
    expect($reward->description)->toBe('This is a new reward');
    expect($reward->min_amount->get())->toBe(100);
});

test('It can set a new amount ', function () {
    $reward = Reward::factory()->create();
    $reward->min_amount = new Amount(100);
    $reward->save();
    expect($reward->min_amount->get())->toBe(100);
});

test('A reward may have variants', function () {
    $reward = Reward::factory()->create();
    $reward->variants()->create([
        'variant_name' => 'Variant 1',
        'description' => 'This is a variant description',
    ]);
    expect($reward->variants)->toHaveCount(1);
    $variant = $reward->variants->first();
    expect($variant->name)->toBe('Variant 1');
    // expect($variant->description)->toBe('This is a variant');
    // expect($variant->amount->get())->toBe($reward->min_amount->get());
});

test('A User can update a reward', function () {
    $user = User::factory()->create();
    $reward = Reward::factory()->for($user->currentCampaign)->create();
    $response = actingAs(User::first())
        ->put("app/rewards/{$reward->id}", [
            'reward_name' => 'Updated Reward',
            'description' => 'This is an updated reward',
            'min_amount' => 200,
        ]);
    $reward->refresh();

    expect($reward->name)->toBe('Updated Reward');
    expect($reward->description)->toBe('This is an updated reward');
    expect($reward->min_amount->get())->toBe(200);
});
test('A varaint can be added to a reward', function () {});

test('A reward variant can be removed from a reward', function () {});
