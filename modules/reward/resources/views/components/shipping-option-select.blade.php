<select
    name="shipping_type"
    class="mt-1.5 w-full rounded-lg border-gray-300 text-gray-700 sm:text-sm"
>
    <option value="">{{ __('Please select') }}</option>
    @foreach ($options as $key => $option)
        <option
            value="{{ $key }}"
            {{ $selected === $key ? 'selected' : '' }}
        >{{ $option }}</option>
    @endforeach
</select>
