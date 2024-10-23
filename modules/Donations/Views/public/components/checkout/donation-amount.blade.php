@props(['reward' => null, 'defaultAmount' => 0])
@php
    $rewardDonation = $reward ? true : false;
@endphp

<div
    x-data="donationAmount(@js($defaultAmount))"
    x-on:amount-slider:reset="onSliderReset"
    x-on:amount-slider:change="onSliderChange"
    class="mt-10"
>
    @if ($rewardDonation)
        <p class="mb-2">@lang('Increase your donation amount')</p>
        <div x-show="showOptions">
            @php
                $options = [10, 25, 50, 100];
            @endphp
            <div class="flex gap-2">
                <ul class="flex gap-2">
                    @foreach ($options as $option)
                        <li>
                            <x-public::checkout.choice-chip :option="$option" />
                        </li>
                    @endforeach
                </ul>
                <div>
                    <button
                        x-on:click.prevent="toggleCustomAmount"
                        class="border px-4 py-2 choice-chip text-gray-500 hover:border-black hover:text-black"
                    >
                        @lang('Custom amount')
                    </button>
                </div>
            </div>
        </div>
        <template x-if="showCustomAmount">
            <x-public::checkout.amount-slider
                :closable="true"
                :defaultAmount="0"
            />
        </template>
        <div
            class="flex"
            x-show="optionalAmount != 0"
            x-cloak
        >
            <span>{{ __('New Amount') }}: </span>&nbsp;<span x-money="newAmount"></span>
        </div>
    @else
        <x-public::checkout.amount-slider :$defaultAmount />
    @endif
</div>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('donationAmount', (defaultValue) => ({
            value: 0,
            defaultValue: null,
            showCustomAmount: @js(!$rewardDonation),
            showOptions: @js($rewardDonation),
            init() {
                this.defaultValue = (@js($defaultAmount) / 100)
                this.value = (@js($rewardDonation) ? 0 : this.defaultValue);
                this.$watch('value', () => {
                    if (!this.showOptions) {
                        this.resetCheckBoxStates();
                    }
                    console.log(this.amount);
                    this.optionalAmount = this.value * 100;
                });
            },

            toggleCustomAmount() {
                this.showCustomAmount = !this.showCustomAmount;
                this.showOptions = !this.showOptions;
            },
            onSliderReset() {
                this.resetAndCloseCustomAmount();
            },

            onSliderChange(event) {
                if (@js($rewardDonation) == false) {
                    this.amount = event.detail * 100;
                    return;
                }
                this.value = event.detail;
            },

            resetAndCloseCustomAmount() {
                this.showCustomAmount = !this.showCustomAmount;
                this.showOptions = !this.showOptions;
                this.value = 0;
                this.resetCheckBoxStates();
            },
            onCheckBoxChange(event) {
                this.value = 0;

                document.querySelectorAll('input[type="checkbox"]').forEach((checkbox) => {
                    if (checkbox !== event.target) {
                        checkbox.checked = false;
                    }
                });

                if (event.target.checked) {
                    this.value += parseInt(event.target.value);
                }
            },
            resetCheckBoxStates() {
                document.querySelectorAll('input[type="checkbox"]').forEach((checkbox) => {
                    checkbox.checked = false;
                });
            },
            get newAmount() {
                if (@js($rewardDonation) == false) {
                    return this.value * 100;
                }
                return (this.defaultValue + parseInt(this.value)) * 100
            },

        }))
    })
</script>
