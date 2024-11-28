@props(['settings'])
@php
    $legalPages = ['imprint' => 'Imprint', 'terms' => 'Terms of Service', 'privacypolicy' => 'Privacy Policy'];
@endphp
@foreach ($legalPages as $key => $value)
    @if (!empty(($settingsContent = $settings->get($key))))
        <a
            @if (filter_var($settingsContent, FILTER_VALIDATE_URL)) href="{{ $settingsContent }}"
            target="_blank"
            @else
            href="{{ route('public.legalpage', ['page' => $key]) }}" @endif
            class="text-black p-2 underline underline-offset-8 "
        >
            @lang($value)
        </a>
    @endif
@endforeach
