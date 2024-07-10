@props(['title' => '', 'intentsCount' => 0])
<h2 class="text-2xl font-semibold leading-tight">{{ $title }}</h2>
<nav class="my-4">
    <ul class="flex">
        <li class="mr-6">
            <a
                href="{{ route('recurring-donations.index') }}"
                @class([
                    'font-bold' => request()->routeIs('recurring-donations.index'),
                ])
            >{{ __('Confirmed') }}</a>
        </li>
        <li class="mr-6">
            <a
                href="{{ route('recurring-donations.intents.index') }}"
                @class([
                    '',
                    'font-bold' => request()->routeIs('recurring-donations.intents.index'),
                ])
            >
                {{ __('Unconfirmed') }}
                <span
                    class="bg-amethyst-500 text-white rounded-full inline-flex items-center justify-center
                    h-5 w-5 text-xs"
                >{{ $intentsCount }}</span>
            </a>

        </li>
    </ul>
</nav>
