@props(['backLink' => null, 'title' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.partials.meta')
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/editor.js'])
    @stack('scripts')
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-white">
        <livewire:layout.navigation />

        @if (isset($header) || isset($backlink))
            <header>
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 relative">
                    @isset($backLink)
                        <a
                            class="flex items-center text-xs text-gray-500 absolute top-6 left-6 lg:left-8"
                            href="{{ $backLink }}"
                            wire:navigate
                        >
                            <x-icons.arrow-left />
                            {{ __('Back') }}
                        </a>
                    @endisset
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
        <x-session-alerts />
    </div>
</body>

</html>
