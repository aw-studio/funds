<?php

use App\Models\User;
use Funds\Reward\Models\Reward;
use Funds\Reward\Models\RewardVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);
test('Faqs component is rendered', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get('app/campaigns/'.$user->current_campaign_id.'/content');

    $response
        ->assertOk()
        ->assertSeeVolt('faqs');
});

test('A FAQ can be added', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $component = Volt::test('faqs', ['campaign' => $user->currentCampaign])
        ->set('newFaqName', 'Question 1')
        ->set('newFaqAnswer', 'Answer 1')
        ->call('addFaq');

    $component->assertHasNoErrors();

    $this->assertDatabaseHas('faqs', [
        'question' => 'Question 1',
    ]);
});

test('A Faq can be removed', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $faq = $user->currentCampaign->faqs()->create([
        'question' => 'Question 1',
        'answer' => 'Answer 1',
    ]);

    $component = Volt::test('faqs', ['campaign' => $user->currentCampaign])
        ->call('removeFaq', $faq->id);

    $this->assertDatabaseMissing('faqs', [
        'question' => 'Questions 1',
    ]);
});
// test('A reward variant can be edited', function () {
//     $user = User::factory()->create();
//     $this->actingAs($user);

//     $reward = Reward::factory()
//         ->has(RewardVariant::factory(['name' => 'Variant 1']), 'variants')
//         ->create([
//             'campaign_id' => $user->current_campaign_id,
//         ]);

//     $component = Volt::test('reward-variants', ['reward' => $reward])
//         ->set('edit_variant', $reward->fresh()->variants->first())
//         ->set('edit_variant_name', 'Variant 1 Updated')
//         ->call('updateVariant');

//     $this->assertDatabaseHas('reward_variants', [
//         'name' => 'Variant 1 Updated',
//     ]);
// });
