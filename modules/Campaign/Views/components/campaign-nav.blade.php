<nav class="flex gap-2">
    <a
        href="{{ $campaign->appRoute() }}"
        @class([
            'border-b-2 border-blue-500' => request()->routeIs('campaigns.show'),
        ])
    >
        {{ __('Overview') }}
    </a>
    <a
        href="{{ route('donations.index') }}"
        @class([
            'border-b-2 border-blue-500' => request()->routeIs('donations.*'),
        ])
    >
        {{ __('Donations') }}
    </a>
    <a
        href="{{ route('rewards.index') }}"
        @class([
            'border-b-2 border-blue-500' => request()->routeIs('rewards.*'),
        ])
    >
        {{ __('Rewards') }}
    </a>
</nav>
