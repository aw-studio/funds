<!-- resources/views/components/item-button.blade.php -->
@props(['index'])

<button
    role="tab"
    :aria-selected="isSelected({{ $index }})"
    @keydown="onKeydown"
    {{ $attributes->merge([
        'id' => "tab-{$index}",
        'tabindex' => $index,
    ]) }}
    @click="selectTab({{ $index }})"
>
    {{ $slot }}
</button>
