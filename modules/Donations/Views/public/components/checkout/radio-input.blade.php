<label
    for="{{ $attributes->get('id', $attributes->get('name')) }}"
    class="flex cursor-pointer gap-2
    border border-color-input card-radius
    p-4 hover:border-gray-200
    has-[:checked]:border-blue-500
    {{-- has-[:checked]:ring-1 has-[:checked]:ring-blue-500 --}}
    "
>

    <input
        type="radio"
        class="size-5 border-gray-300 text-blue-500 mt-1"
        {{ $attributes }}
    />
    <div>
        {{ $slot }}
    </div>
</label>
