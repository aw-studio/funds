@props(['reward'])
@if ($reward !== null)
    <div>
        <h2 class="text-2xl font-semibold">{{ __('Shipping') }}</h2>
        <div class="grid grid-cols-2 gap-2 mb-5">
            <x-input
                name="shipping_name"
                type="text"
                placeholder="{{ __('Name') }}"
                value="{{ old('shipping_name') }}"
                required
            />
        </div>
    </div>
@endif
