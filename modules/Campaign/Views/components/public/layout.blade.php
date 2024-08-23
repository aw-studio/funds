<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>{{ $campaign->name ?? '' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --campaign-color-primary: {{ $campaign->settings['primary_color'] }};
        }

        .bg-primary {
            background-color: var(--campaign-color-primary);
        }
    </style>
</head>

<body>

    <main>
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                {{ $slot }}
            </div>
        </div>
    </main>
    @livewireScripts
</body>

</html>
