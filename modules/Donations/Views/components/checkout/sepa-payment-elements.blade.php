<div {{ $attributes->merge([]) }}>
    <style>
        .container {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 8px;
            font-size: 16px;
        }

        input {
            padding: 8px;
            font-size: 16px;
            width: 300px;
        }
    </style>
    <div class="container">
        <fieldset class="space-y-4">
            {{-- <legend class="sr-only">Delivery</legend> --}}
            <div>
                <x-radio-input
                    id="FrequencyYearly"
                    name="frequency"
                    value="yearly"
                    checked
                >
                    <div>
                        <p class="">{{ __('Yearly') }}</p>

                        <p class="mt-1 text-gray-900"><span x-money="amount"></span></p>
                    </div>
                </x-radio-input>
            </div>

            <div>
                <x-radio-input
                    id="FrequencyQuarterly"
                    name="frequency"
                    value="quarterly"
                >
                    <div>
                        <p class="">{{ __('Quarterly') }}</p>

                        <p class="mt-1 text-gray-900"><span x-money="amount / 4"></span></p>
                    </div>
                </x-radio-input>
            </div>
            <div>
                <x-radio-input
                    id="FrequencyMonthly"
                    name="frequency"
                    value="monthly"
                >
                    <div>
                        <p class="">{{ __('Monthly') }}</p>

                        <p class="mt-1 text-gray-900"><span x-money="amount / 12"></span></p>
                    </div>
                </x-radio-input>
            </div>
        </fieldset>
        <label
            for="account_holder"
            class="text-sm text-gray-600"
        >{{ __('Account Holder') }}</label>
        <input
            id="account_holder"
            type="text"
            name="account_holder"
            placeholder="John Doe"
            autocomplete="billing"
            aria-required="true"
            @class([
                'border border-gray-200',
                'border-red-500' => $errors->has('account_holder'),
            ])
            value="{{ old('account_holder') }}"
        >
        @error('account_holder')
            <div class="text-red-500">{{ $message }}</div>
        @enderror
        <label
            for="iban"
            class="text-sm text-gray-600"
        >IBAN</label>
        <input
            id="iban"
            type="text"
            inputmode="numeric"
            name="iban"
            placeholder="DE01 1234 1234 1234 1234"
            autocomplete="billing "
            aria-required="true"
            @class([
                'border border-gray-200',
                'border-red-500' => $errors->has('iban'),
            ])
            maxlength="34"
            value="{{ old('iban') }}"
        >
        @error('iban')
            <div class="text-red-500">{{ $message }}</div>
        @enderror
        <script>
            document.getElementById('iban').addEventListener('input', function(e) {
                let value = e.target.value.replace(/\s+/g, ''); // Remove all whitespaces
                let formattedValue = '';

                for (let i = 0; i < value.length; i++) {
                    if (i > 0 && i % 4 === 0) {
                        formattedValue += ' ';
                    }
                    formattedValue += value[i];
                    console.log(formattedValue);
                }

                formattedValue = formattedValue.slice(0, 2).toUpperCase() + formattedValue.slice(2);

                e.target.value = formattedValue;
            });
        </script>
        {{ __('Donation SEPA hint') }}

    </div>
</div>
