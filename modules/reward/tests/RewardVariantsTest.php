<?php

use App\Models\User;
use Funds\Reward\Models\Reward;
use Funds\Reward\Models\RewardVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);
test('Reward Variants component is rendered on the reward edit page', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $reward = Reward::factory()
        ->create([
            'campaign_id' => $user->current_campaign_id,
        ]);

    $response = $this->get('app/rewards/'.$reward->id.'/edit');

    $response
        ->assertOk()
        ->assertSeeVolt('reward-variants');
});

test('A reward variant can be added', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $reward = Reward::factory()
        ->create([
            'campaign_id' => $user->current_campaign_id,
        ]);

    $component = Volt::test('reward-variants', ['reward' => $reward])
        ->set('new_variant_name', 'Variant 1')
        ->call('storeVariant');

    $component->assertHasNoErrors();

    $this->assertDatabaseHas('reward_variants', [
        'reward_id' => $reward->id,
        'name' => 'Variant 1',
    ]);
});

test('A reward variant can be edited', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $reward = Reward::factory()
        ->has(RewardVariant::factory(['name' => 'Variant 1']), 'variants')
        ->create([
            'campaign_id' => $user->current_campaign_id,
        ]);

    $component = Volt::test('reward-variants', ['reward' => $reward])
        ->set('edit_variant', $reward->fresh()->variants->first())
        ->set('edit_variant_name', 'Variant 1 Updated')
        ->call('updateVariant');

    $this->assertDatabaseHas('reward_variants', [
        'name' => 'Variant 1 Updated',
    ]);
});

test('A reward variant can be removed', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $reward = Reward::factory()
        ->has(RewardVariant::factory(['name' => 'Variant 1']), 'variants')
        ->create([
            'campaign_id' => $user->current_campaign_id,
        ]);

    $component = Volt::test('reward-variants', ['reward' => $reward])
        ->call('removeVariant', $reward->fresh()->variants->first()->id);

    $this->assertDatabaseMissing('reward_variants', [
        'name' => 'Variant 1',
    ]);
});
