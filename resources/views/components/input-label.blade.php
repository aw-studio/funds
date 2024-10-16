@props(['value', 'required' => false, 'hint' => null])

<label {{ $attributes->class(['block text-sm text-black mb-2'])->merge() }}>
    {{ $value ?? $slot }}
    @if ($required)
        <span class="text-red-500">*</span>
    @endif
    @if (isset($hint))
        <span class="text-gray-500 text-xs block">{{ $hint }}</span>
    @endif
</label>
