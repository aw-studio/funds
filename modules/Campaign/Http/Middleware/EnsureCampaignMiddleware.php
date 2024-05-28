<?php

namespace Funds\Campaign\Http\Middleware;

use Closure;
use Funds\Donations\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class EnsureCampaignMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (! auth()->user()) {
            return response('Unauthorized', 401);
        }

        $campaign = auth()->user()->currentCampaign;

        if (! $campaign) {
            return response('Campaign not found', 404);
        }

        Context::add('campaign', $campaign);

        // make the campaign acessible in all views
        // this way we don't have to  resolve it in the layout or in every controller method
        View::share('campaign', $campaign);

        // And make routes use the campaign by default
        URL::defaults(['campaign' => $campaign]);

        // scope all donations to the current campaign
        Donation::addGlobalScope('campaign', function ($builder) use ($campaign) {
            $builder->where('campaign_id', $campaign->id);
        });

        return $next($request);
    }
}
