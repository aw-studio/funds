@props([
    'label' => null,
    'errorKey' => $attributes->get('name'),
    'value' => null,
    'maxlength' => null,
])
@php
    $limit = $maxlength;
    $content = $value ?? (string) $slot;
@endphp
<div>
    @isset($label)
        <x-input-label
            :value="$label"
            :for="$attributes->get('id', $attributes->get('name'))"
            :required="$attributes->get('required', false)"
        />
    @endisset
    <div
        x-data="{
            content: @js($content),
            limit: @js($limit),
        }"
        class="flex flex-col gap-1"
    >
        <textarea
            x-model="content"
            maxlength="{{ $limit }}"
            {{ $attributes->class([
                'mt-1 w-full rounded-md border-gray-200 sm:text-s',
                'border-red-500' => $errors->has($errorKey),
                'bg-gray-50' => $attributes->get('disabled'),
            ]) }}
        >{{ $content }}</textarea>
        @if ($maxlength)
            <p class="text-xs self-end">
                <span
                    x-show="limit > 0"
                    x-text="content.length"
                >{{ strlen($content) }}</span> /
                <span>{{ $limit }}</span>
            </p>
        @endif
    </div>
    <x-input-error
        :messages="$errors->get($errorKey)"
        class="mt-2"
    />
</div>
