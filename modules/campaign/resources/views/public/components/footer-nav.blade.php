@props(['settings'])
@if ($settings->get('imprint'))
    <a
        href="{{ route('pages.imprint') }}"
        class="text-black p-2"
    >
        @lang('Imprint')
    </a>
@endif
@if ($settings->get('terms'))
    <a
        href="{{ route('pages.terms') }}"
        class="text-black p-2"
    >
        @lang('Terms of Service')
    </a>
@endif

@if ($settings->get('privacypolicy'))
    <a
        href="{{ route('pages.privacy') }}"
        class="text-black p-2"
    >
        @lang('Privacy Policy')
    </a>
@endif
