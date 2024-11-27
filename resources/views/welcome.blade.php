<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.partials.meta')

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased font-sans">
    <div class="bg-gray-50">
        <div class="relative min-h-screen flex flex-col items-center justify-center ">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                    <div class="flex lg:justify-center lg:col-start-2">
                        <x-application-logo class="block h-9 w-auto fill-current text-black " />
                    </div>

                </header>

                <main class="mt-6">
                    <div class="flex gap-6 lg:gap-8">
                        @php
                            $campaigns = \Funds\Campaign\Models\Campaign::query()->running()->get();
                        @endphp
                        <div class="w-1/2">
                            @if ($campaigns->isEmpty())
                                <x-card class="bg-white mb-4">
                                    <span class="text-sm text-gray-500">No Campaigns</span>
                                    <p class="text-gray-700 my-4">There are no campaigns running at the moment.</p>
                                </x-card>
                            @endif
                            @foreach ($campaigns as $campaign)
                                <a href="{{ route('campaigns.public.show', $campaign) }}">
                                    <x-card class="bg-white mb-4">
                                        <span class="text-sm text-gray-500">Current Campaign</span>

                                        <x-section-headline :value="$campaign->name" />
                                        <p class="text-gray-700 my-4">{{ $campaign->description }}</p>
                                    </x-card>
                                </a>
                            @endforeach
                        </div>

                        @if (app()->environment(['local', 'staging']))
                            <div class="self-start w-1/2">
                                <x-card class="bg-white">
                                    <p class="text-sm text-gray-500">{{ __('Quick Access') }}</p>
                                    @auth()
                                        <p class="mb-4">Hi {{ auth()->user()->name }}!</p>
                                    @endauth
                                    <a href="{{ route('dashboard') }}">
                                        <x-button>
                                            {{ __('Go to Dashboard') }}
                                        </x-button>
                                    </a>
                                </x-card>
                            </div>
                        @endif
                    </div>
                </main>
            </div>
        </div>
    </div>
</body>

</html>
