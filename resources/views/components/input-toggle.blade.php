@props([
    'size' => 'md',
    'errorKey' => $attributes->get('name'),
    'label' => null,
])
<div>
    <div class="flex gap-2">
        <label
            tabindex="-1"
            for="{{ $attributes->get('id') ?? $attributes->get('name', '') }}"
            class="relative flex items-center select-none group"
        >
            <input
                id="{{ $attributes->get('id') ?? $attributes->get('name', '') }}"
                class="translate-x-0 transform transition ease-in-out duration-200 cursor-pointer shadow checked:bg-none peer focus:ring-0 focus:ring-offset-0 focus:outline-none bg-white absolute mx-1 my-auto inset-y-0 border-0 appearance-none checked:text-white  checked:translate-x-3 w-3 h-3 rounded-full"
                type="checkbox"
                value="1"
                {{ $attributes }}
            >

            <div
                class="block cursor-pointer transition ease-in-out duration-300 peer-focus:ring-2 peer-focus:ring-offset-2 group-focus:ring-2 group-focus:ring-offset-2 h-5 w-8 rounded-full bg-gray-200 peer-checked:bg-orange-500 peer-focus:ring-orange-600 group-focus:ring-orange-600  invalidated:bg-orange-200 invalidated:peer-focus:bg-orange-200 invalidated:peer-focus:ring-oraange-200  invalidated:group-focus:ring-orange-200">
            </div>

        </label>
        @isset($label)
            <label
                for="{{ $attributes->get('id') ?? $attributes->get('name', '') }}"
                class="cursor-pointer"
            >
                {{ $label }}
            </label>
        @endisset
    </div>
    <x-input-error
        :messages="$errors->get($errorKey)"
        class="mt-2"
    />
</div>
