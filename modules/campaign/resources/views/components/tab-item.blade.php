<!-- resources/views/components/tab-item.blade.php -->
@props(['index'])

<div
    x-show="selectedTab === {{ $index }}"
    role="tabpanel"
    class="tab-content"
    {{ $attributes->merge([
        'id' => "tabpanel-$index",
        'aria-labelledby' => "tab-{$index}",
        'tabindex' => $index,
    ]) }}
    @if ($index > 0) x-cloak @endif
>
    {{ $slot }}
</div>
