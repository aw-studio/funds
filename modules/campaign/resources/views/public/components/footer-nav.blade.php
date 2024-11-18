@props(['settings'])
@if ($settings->get('imprint'))
    <a
        href="{{ route('pages.imprint') }}"
        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
    >
        @lang('Imprint')
    </a>
@endif
@if ($settings->get('terms'))
    <a
        href="{{ route('pages.terms') }}"
        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
    >
        @lang('Terms of Service')
    </a>
@endif

@if ($settings->get('privacypolicy'))
    <a
        href="{{ route('pages.privacy') }}"
        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
    >
        @lang('Privacy Policy')
    </a>
@endif
