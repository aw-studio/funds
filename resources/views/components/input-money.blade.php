@props(['value' => null])
<div
    class="relative"
    x-data="{
        amount: @js($value),
        get displayValue() {
            if (this.amount === null) {
                return ''
            }
            return (this.amount / 100).toFixed(2).replace('.', ',')
        },
        demaskValue(value) {
            this.amount = parseInt(value.replace(/[^0-9]/g, '')) || 0
        }
    }",
>
    <x-input
        x-bind:value="displayValue"
        x-on:input="demaskValue($el.value)"
        placeholder="{{ __('Amount') }}"
        class="w-full rounded-md border-gray-200 ps-8 "
        {{ $attributes->class('w-full rounded-md border-gray-200 ps-8 ')->merge([
            'type' => 'text',
        ]) }}
    >
        <x-slot name="prefix">
            €
        </x-slot>
    </x-input>
    <input
        type="hidden"
        x-model="amount"
        name="{{ $attributes->get('name') }}"
    />
</div>
