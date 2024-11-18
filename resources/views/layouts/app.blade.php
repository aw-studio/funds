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

        @isset($backLink)
            <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8 pb-0">
                <a
                    class="mb-2 flex items-center text-xs text-gray-500"
                    href="{{ $backLink }}"
                >
                    <x-icons.arrow-left />
                    {{ __('Back') }}
                </a>
            </div>
        @endisset
        <!-- Page Heading -->
        @if (isset($header))
            <header class="">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
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
