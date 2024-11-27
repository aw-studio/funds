@props(['option' => '', 'labelText'])
<div class="choice-chip-wrapper">
    <input
        id="optionAdd{{ $option }}"
        type="checkbox"
        value="{{ $option }}"
        class="hidden peer"
        x-on:change="onCheckBoxChange"
    >
    <label
        for="optionAdd{{ $option }}"
        class="choice-chip inline-flex items-center justify-center w-full p-2 px-4 border cursor-pointer  hover:border-black hover:text-black

        "
    >
        <div class="">
            {{ $labelText ?? '+' . Number::currencyWithoutDigits($option) }}
        </div>

    </label>
</div>
