<?php

use Funds\Core\Support\Amount;
use Funds\Reward\Models\Reward;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

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
            'name' => 'New Reward',
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
