<div {{ $attributes->merge([]) }}>
    <div class="grid grid-cols-2 gap-2">
        <x-input
            id="account_holder"
            type="text"
            name="account_holder"
            placeholder="John Doe"
            label="Account Holder"
            autocomplete="billing"
            aria-required="true"
            @class([
                'border border-gray-200',
                'border-red-500' => $errors->has('account_holder'),
            ])
            value="{{ old('account_holder') }}"
        />

        <x-input
            id="iban"
            type="text"
            inputmode="numeric"
            name="iban"
            placeholder="DE01 1234 1234 1234 1234"
            autocomplete="billing"
            aria-required="true"
            @class([
                'border border-gray-200',
                'border-red-500' => $errors->has('iban'),
            ])
            maxlength="34"
            value="{{ old('iban') }}"
            label="IBAN"
            x-data="{
                value: '{{ old('iban') }}',
                formatValue() {
                    this.value = this.value.replace(/\s+/g, '').replace(/(.{4})/g, '$1 ').trim().toUpperCase();
                }
            }"
            x-model="value"
            x-on:input="formatValue"
        />

    </div>
    <p class="my-4">
        {{ __('Donation SEPA hint') }}
    </p>
</div>
