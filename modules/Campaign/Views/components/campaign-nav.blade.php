@php
    $items = [
        'Overview' => [
            'route' => $campaign->appRoute(),
            'active' => request()->routeIs('campaigns.show'),
        ],
        'Donations' => [
            'route' => route('donations.index'),
            'active' => request()->routeIs('donations.*'),
        ],
        'Rewards' => [
            'route' => route('rewards.index'),
            'active' => request()->routeIs('rewards.*'),
        ],
        'Content Editor' => [
            'route' => route('campaigns.content.edit', ['campaign' => $campaign]),
            'active' => request()->routeIs('campaigns.content.*'),
        ],
    ];
@endphp

<div>
    <div class="sm:hidden">
        <label
            for="Tab"
            class="sr-only"
        >Tab</label>

        <select
            id="Tab"
            class="w-full rounded-md border-gray-200"
            onchange="window.location.href = this.value"
        >
            @foreach ($items as $label => $item)
                <option
                    value="{{ $item['route'] }}"
                    {{ $item['active'] ? 'selected' : '' }}
                >{{ __($label) }}</option>
            @endforeach
        </select>
    </div>

    <div class="hidden sm:block">
        <div class="border-b border-gray-200">
            <nav
                class="-mb-px flex gap-6"
                aria-label="Tabs"
            >
                @foreach ($items as $label => $item)
                    <a
                        href="{{ $item['route'] }}"
                        @class([
                            'shrink-0 border-b-2 border-transparent px-1 pb-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700',
                            'border-amethyst-500 border-b-3' => $item['active'],
                        ])
                    >
                        {{ __($label) }}
                    </a>
                @endforeach

            </nav>
        </div>
    </div>
</div>
