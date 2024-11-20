<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('A user can see a page to edit a the campaigns pitch', function () {
    $response = $this->actingAs($user = User::factory()->create())
        ->get('app/campaigns/'.$user->currentCampaign->id.'/content/pitch');

    $response->assertViewIs('campaign::content.pitch');
});

test('A user can update a campaigns content', function () {
    $this->withoutExceptionHandling();
    $this->actingAs($user = User::factory()->create())
        ->post('app/campaigns/'.$user->currentCampaign->id.'/content/pitch', [
            'description' => 'Test Description',
        ]);
    expect($user->currentCampaign->fresh()->description)->toBe('Test Description');
});
