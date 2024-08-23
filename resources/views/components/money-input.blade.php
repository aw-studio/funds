@props(['value' => null])
<div
    x-data="{
        amount: @js($value->get()),
        get displayValue() {
            return (this.amount / 100).toFixed(2).replace('.', ',')
        },
        demaskValue(value) {
            this.amount = parseInt(value.replace(/[^0-9]/g, '')) || 0
        }
    }",
    class="-mr-2"
>
    <!--
  Heads up! 👋

  Plugins:
    - @tailwindcss/forms
-->

    <div class="relative">
        <x-input
            id="UserEmail"
            type="text"
            x-bind:value="displayValue"
            x-on:input="demaskValue($el.value)"
            placeholder="{{ __('Amount') }}"
            class="w-full rounded-md border-gray-200 ps-8 shadow-sm sm:text-sm"
            {{ $attributes->class('w-full rounded-md border-gray-200 ps-8 shadow-sm sm:text-sm') }}
        />

        <span class="pointer-events-none absolute inset-y-0 start-0 grid w-10 place-content-center text-gray-500">
            €
        </span>
    </div>
    {{-- <x-input /> --}}
    <input
        type="hidden"
        x-model="amount"
        name="{{ $attributes->get('name') }}"
    />
</div>
