@php
    $classes = '';
    if ($data['stretched']) {
        $classes .= ' image--stretched';
    }
    if ($data['withBorder']) {
        $classes .= ' image--bordered';
    }
    if ($data['withBackground']) {
        $classes .= ' image--backgrounded';
    }

@endphp

<figure class="image {{ $classes }}">
    {{-- <img
        src="{{ $data['file']['url'] }}"
        alt="{{ $data['caption'] ?: '' }}"
        loading="lazy"
    > --}}
    @if ($data['media']->mime_type === 'image/gif')
        <img
            src="{{ $data['media']->getUrl() }}"
            alt="{{ $data['caption'] ?: '' }}"
            loading="lazy"
        >
    @else
        {{ $data['media'] }}
    @endif
    @if (!empty($data['caption']))
        <footer class="image-caption">
            {{ $data['caption'] }}
        </footer>
    @endif
</figure>
