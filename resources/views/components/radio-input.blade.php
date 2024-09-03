<label
    for="{{ $attributes->get('id', $attributes->get('name')) }}"
    class="flex cursor-pointer justify-between gap-4 rounded-lg border border-gray-100  p-4 hover:border-gray-200 has-[:checked]:border-blue-500 has-[:checked]:ring-1 has-[:checked]:ring-blue-500"
>
    <div>
        {{ $slot }}
    </div>

    <input
        type="radio"
        class="size-5 border-gray-300 text-blue-500"
        {{ $attributes }}
    />
</label>
