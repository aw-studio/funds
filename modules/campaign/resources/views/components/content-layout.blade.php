<x-campaign::layout :campaign="$campaign">
    @php
        $navItems = [
            [
                'name' => __('Pitch'),
                'route' => route('campaigns.content.pitch.edit', ['campaign' => $campaign]),
                'isActive' => request()->routeIs('campaigns.content.pitch.edit'),
            ],
            [
                'name' => __('Story'),
                'route' => route('campaigns.content.story.edit', ['campaign' => $campaign]),
                'isActive' => request()->routeIs('campaigns.content.story.edit'),
            ],
            [
                'name' => __('FAQ'),
                'route' => route('campaigns.content.faqs.edit', ['campaign' => $campaign]),
                'isActive' => request()->routeIs('campaigns.content.faqs.edit'),
            ],
            [
                'name' => __('Design'),
                'route' => route('campaigns.content.style-settings.edit', ['campaign' => $campaign]),
                'isActive' => request()->routeIs('campaigns.content.style-settings.edit'),
            ],
        ];
    @endphp

    <div class="lg:flex gap-4">
        <aside class="w-60">
            <ul>
                @foreach ($navItems as $item)
                    <li @class([
                        'p-2 border-l-2 rounded-r-lg',
                        'border-gray-50' => !$item['isActive'],
                        'bg-slate-100 text-black border-purple-500' => $item['isActive'],
                    ])>
                        <a
                            href="{{ $item['route'] }}"
                            wire:navigate
                        >
                            {{ $item['name'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </aside>

        <div class="w-full">
            {{ $slot }}
        </div>
    </div>
</x-campaign::layout>
