@props(['defaultAmount', 'closable' => false, 'max' => 500])
<div
    class="amountSlider flex gap-4"
    x-data="amountSlider(@js($defaultAmount))"
>

    <div class="relative">
        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
            €
        </div>
        <input
            id="input-group-1"
            type="number"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
            x-model="value"
        >
    </div>
    <div
        class="relative flex items-center w-full"
        :style="`--progress:${progress}`"
    >
        <div
            class="
                overlay
                absolute left-2.5 right-2.5 h-2.5 overflow-hidden
                before:absolute
                before:inset-0
                [&[x-cloak]]:hidden
            "
            aria-hidden="true"
            x-cloak
        ></div>
        <input
            class="
                thumb
                relative appearance-none cursor-pointer w-full bg-transparent focus:outline-none
                [&::-webkit-slider-thumb]:appearance-none
                [&::-webkit-slider-thumb]:h-5
                [&::-webkit-slider-thumb]:w-5
                [&::-webkit-slider-thumb]:focus-visible:ring
                [&::-webkit-slider-thumb]:focus-visible:ring-indigo-300
                [&::-moz-range-thumb]:h-5
                [&::-moz-range-thumb]:w-5
                [&::-moz-range-thumb]:rounded-full
                [&::-moz-range-thumb]:bg-white
                [&::-moz-range-thumb]:border-none
                [&::-moz-range-thumb]:shadow
                [&::-moz-range-thumb]:focus-visible:ring
                [&::-moz-range-thumb]:focus-visible:ring-indigo-300
            "
            type="range"
            min="0"
            aria-label="Amount Slider"
            x-ref="slider"
            x-model="value"
        >
    </div>
    @if ($closable)
        <div class="flex items-center">
            <span
                class="p-2 cursor-pointer text-xl"
                x-on:click="resetAndCloseCustomAmount();"
            >
                <svg
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M18 6L6 18"
                        stroke="#274DBA"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                    <path
                        d="M6 6L18 18"
                        stroke="#274DBA"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>

            </span>
        </div>
    @endif
</div>
@pushOnce('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('amountSlider', (defaultValue) => ({
                value: 0,
                max: @js(max($max, 500)),
                step: 1,
                defaultValue: null,

                init() {

                    if (this.max > 500) {
                        this.step = 10
                    }
                    if (this.max > 1000) {
                        this.step = 50
                    }
                    if (this.max > 5000) {
                        this.step = 100
                    }

                    this.$refs.slider.setAttribute('max', this.max);
                    this.$refs.slider.setAttribute('step', this.step);

                    this.defaultValue = (@js($defaultAmount) / 100)
                    this.value = this.defaultValue;

                    this.$watch('value', () => {
                        this.$dispatch('amount-slider:change', this.value);
                    });
                },


                resetAndCloseCustomAmount() {
                    this.$dispatch('amount-slider:reset');
                },

                get progress() {
                    return (this.value / this.max) * 100 + '%';
                },

            }))
        })
    </script>
@endpushOnce
