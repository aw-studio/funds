@props(['reward' => null])
@php
    $defaulAmount = $reward ? $reward->min_amount->get() : 10;
@endphp
<div
    x-data="{
        get displayValue() {
            return (this.amount / 100).toFixed(2).replace('.', ',')
        },
        demaskValue(value) {
            this.amount = parseInt(value.replace(/[^0-9]/g, ''))
        }
    }"
    class="-mr-2"
>
    <x-input
        type="text"
        x-bind:value="displayValue"
        x-on:input="demaskValue($el.value)"
        placeholder="{{ __('Amount') }}"
    />
    <x-input
        type="hidden"
        name="amount"
        x-model="amount"
    />
</div>
