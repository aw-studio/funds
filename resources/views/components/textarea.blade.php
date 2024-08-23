@props([
    'label' => null,
    'errorKey' => $attributes->get('name'),
    'value' => null,
])
<div>
    @isset($label)
        <x-input-label
            :value="$label"
            :for="$attributes->get('id', $attributes->get('name'))"
            :required="$attributes->get('required', false)"
        />
    @endisset

    <textarea
        {{ $attributes->class([
                'mt-1 w-full rounded-md border-gray-200 sm:text-s',
                'border-red-500' => $errors->has($errorKey),
                'bg-gray-50' => $attributes->get('disabled'),
            ])->merge(['disabled' => false]) }}
    >{{ $value ?? $slot }}</textarea>
    <x-input-error
        :messages="$errors->get($errorKey)"
        class="mt-2"
    />
</div>
