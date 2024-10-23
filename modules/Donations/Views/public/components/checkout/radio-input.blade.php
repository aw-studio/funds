<label
    for="{{ $attributes->get('id', $attributes->get('name')) }}"
    class="radio flex cursor-pointer gap-2  border p-4 hover:border-gray-200"
>
    <input
        type="radio"
        class="size-5 border-gray-300 mt-1"
        {{ $attributes }}
    />
    <div>
        {{ $slot }}
    </div>
</label>
