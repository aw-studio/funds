@props(['header' => true, 'campaign' => null])
@php
    $metaDescription = $campaign?->meta_description ?? $campaign?->description ?? '';
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>{{ $campaign?->name ?? '' }}</title>
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
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

    <!-- HTML Meta Tags -->
    <meta
        name="description"
        content="{{ $metaDescription }}"
    >

    <!-- Facebook Meta Tags -->
    <meta
        property="og:url"
        content="{{ url()->current() }}"
    >
    <meta
        property="og:type"
        content="website"
    >
    <meta
        property="og:title"
        content="{{ $campaign?->name }}"
    >
    <meta
        property="og:description"
        content="{{ $metaDescription }}"
    >
    @if ($og_image = $campaign?->getFirstMediaUrl('og_image'))
        <meta
            property="og:image"
            content="{{ $og_image }}"
        >
    @endif

    <!-- Twitter Meta Tags -->
    <meta
        name="twitter:card"
        content="summary_large_image"
    >
    <meta
        property="twitter:domain"
        content="{{ request()->getHost() }}"
    >
    <meta
        property="twitter:url"
        content="{{ url()->current() }}"
    >
    <meta
        name="twitter:title"
        content="{{ $campaign?->name }}"
    >
    <meta
        name="twitter:description"
        content="{{ $metaDescription }}"
    >
     @if ($twitter_image = $campaign?->getFirstMediaUrl('twitter_image'))
        <meta
            name="twitter:image"
            content="{{ $twitter_image }}"
        >
    @endif
    @vite(['resources/css/app.css', 'resources/js/app.js', 'modules/campaign/resources/css/public.css'])
    @if ($campaign)
        <style>
            :root {
                {{ $campaign?->getCssVariables() }}
            }

            {{ $campaign?->settings['custom_css'] ?? '' }}
        </style>
    @endif
    @stack('scripts')

</head>

<body class="campaign   {{ $attributes->get('bodyClass', '') }}">
    @if ($campaign && !$campaign?->isPublished())
        <div class="sticky top-0 z-10 p-4 text-sm text-center text-purple-500 bg-purple-100 border-b border-purple-500">
            {{ __('This campaign is not published yet.') }}
            {{ __('Some features may not work as expected.') }}
            <a
                href="{{ route('campaigns.show', $campaign) }}"
                class="underline"
            >{{ __('Edit Campaign') }}</a>

        </div>
    @endif
    @if ($header)
        <x-public::layout-header />
    @endif
    <main>
        <div class="pb-6 ">
            {{ $slot }}
        </div>
    </main>
    <x-public::layout-footer />
    @livewireScripts
</body>

</html>
