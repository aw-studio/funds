<?php

use App\Models\User;
use Funds\Campaign\Http\Middleware\EnsureCampaignMiddleware;
use Funds\Campaign\Models\Campaign;
use Funds\Donations\Models\Donation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

use function Pest\Laravel\actingAs;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    $this->middleware = new EnsureCampaignMiddleware();
});

test('middleware returns 401 for unauthorized user', function () {
    $request = Request::create('/test', 'GET');

    $response = $this->middleware->handle($request, function () {
    });

    expect($response->getStatusCode())->toBe(401);
});

// Test no current campaign
test('middleware returns 404 if no current campaign', function () {
    $user = User::factory([
        'current_campaign_id' => null,
    ])->create();

    actingAs($user);

    $request = Request::create('/test', 'GET');

    $response = $this->middleware->handle($request, function () {
    });

    expect($response->getStatusCode())->toBe(404);
});

// Test successful request
test('middleware sets campaign context and shares company with views', function () {
    $campaign = Campaign::factory()->create();
    $user = User::factory()->create([
        'current_campaign_id' => $campaign->id,
    ]);
    actingAs($user);

    $request = Request::create('/test', 'GET');

    $response = $this->middleware->handle($request, function () {
        return response('OK', 200);
    });

    // Check response status
    expect($response->getStatusCode())->toBe(200);

    expect(Context::get('campaign')->id)->toBe($campaign->id);

    // Check campaign is shared with views
    expect(View::shared('campaign')->id)->toBe($campaign->id);

});

test('middleware sets URL defaults', function () {
    $campaign = Campaign::factory()->create();

    $user = User::factory()->create([
        'current_campaign_id' => $campaign->id,
    ]);

    actingAs($user);

    $request = Request::create('/test', 'GET');

    $response = $this->middleware->handle($request, function () {
        return response('OK', 200);
    });

    // Check URL defaults
    expect(URL::getDefaultParameters()['campaign']->id)->toBe($campaign->id);
});

test('middleware sets donation scope', function () {
    $campaign = Campaign::factory()->create();
    $user = User::factory()->create([
        'current_campaign_id' => $campaign->id,
    ]);
    actingAs($user);

    $request = Request::create('/test', 'GET');

    $response = $this->middleware->handle($request, function () {
        return response('OK', 200);
    });

    // Check global scope on donations
    $query = Donation::query()->toSql();
    expect($query)->toContain('where "campaign_id" = ?');
});
