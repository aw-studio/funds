<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('A user can see a page to edit a campaign', function () {

    $response = $this->actingAs($user = User::factory()->create())
        ->get('app/campaigns/'.$user->currentCampaign->id.'/content');

    $response->assertViewIs('campaign::content');
});

test('A user can update a campaigns content', function () {
    $this->withoutExceptionHandling();
    $this->actingAs($user = User::factory()->create())
        ->post('app/campaigns/'.$user->currentCampaign->id.'/content', [
            'content' => 'Test Content',
            'description' => 'Test Description',
        ]);

    expect($user->currentCampaign->fresh()->content)->toBe('Test Content');
});
