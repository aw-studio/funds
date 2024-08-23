@props(['value', 'required' => false, 'hint' => null])

<label {{ $attributes->class(['block font-medium text-sm text-gray-700 mb-2'])->merge() }}>
    {{ $value ?? $slot }}
    @if ($required)
        <span class="text-red-500">*</span>
    @endif
    @if (isset($hint))
        <span class="text-gray-500 text-sm block">{{ $hint }}</span>
    @endif
</label>
