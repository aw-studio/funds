<x-select
    name="country"
    required
    autocomplete="countryCode"
    label="{{ __('Country') }}"
>
    <option value="">{{ __('Country') }}</option>
    @foreach ($countries as $countryCode => $country)
        <option
            value="{{ $countryCode }}"
            name="countryCode"
            {{ $countryCode == $selectedOption ? 'selected' : '' }}
        >{{ $country }}</option>
    @endforeach
</x-select>
