@props([
    'label' => null,
    'errorKey' => $attributes->get('name'),
])
<div class="">
    @isset($label)
        <x-input-label
            :value="$label"
            :for="$attributes->get('id', $attributes->get('name'))"
            :required="$attributes->get('required', false)"
        />
    @endisset
    <div class="relative">
        <input
            {{ $attributes->class([
                    'mt-1 w-full rounded-md border-gray-200 sm:text-s',
                    'border-red-500' => $errors->has($errorKey),
                    'bg-gray-50' => $attributes->get('disabled'),
                    'ps-8 ' => isset($prefix),
                ])->merge(['disabled' => false]) }}
        />
        @isset($prefix)
            <span class="pointer-events-none absolute inset-y-0 start-0 grid w-10 place-content-center text-gray-500 mt-1">
                {{ $prefix }}
            </span>
        @endisset
    </div>
    <x-input-error
        :messages="$errors->get($errorKey)"
        class="mt-2"
    />
</div>
