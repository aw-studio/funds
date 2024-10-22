@props(['header' => true, 'campaign'])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>{{ $campaign->name ?? '' }}</title>
    <link
        rel="icon"
        type="image/png"
        href="/favicon-48x48.png"
        sizes="48x48"
    />
    <link
        rel="icon"
        type="image/svg+xml"
        href="/favicon.svg"
    />
    <link
        rel="shortcut icon"
        href="/favicon.ico"
    />
    <link
        rel="apple-touch-icon"
        sizes="180x180"
        href="/apple-touch-icon.png"
    />
    <link
        rel="manifest"
        href="/site.webmanifest"
    />
    @vite(['resources/css/app.css', 'resources/js/app.js', 'modules/Campaign/Views/public/public.css'])
    <style>
        {{-- {{ $campaign->settings['custom_css'] ?? '' }} --}} :root {
            {{ $campaign->getCssVariables() }}
        }
    </style>
    @stack('scripts')

</head>

<body class="bg-general-color campaign {{ $attributes->get('bodyClass', '') }} nor-theme">
    @if ($header)
        <x-public::layout-header />
    @endif
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
