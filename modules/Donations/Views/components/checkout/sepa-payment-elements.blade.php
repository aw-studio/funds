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
    </div>
</div>
