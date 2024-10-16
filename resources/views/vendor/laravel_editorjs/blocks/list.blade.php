@php
    $listType = $data['style'] ?? ($data['type'] ?? 'unordered');
    $tag = $listType === 'unordered' ? 'ul' : 'ol';

    foreach ($data['items'] as $key => $item) {
        $data['items'][$key] = new \Illuminate\Support\HtmlString($item);
    }
@endphp

<{{ $tag }}>
    @foreach ($data['items'] as $item)
        <li>{{ $item }}</li>
    @endforeach
    </{{ $tag }}>
