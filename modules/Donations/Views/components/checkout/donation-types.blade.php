<?php
use Funds\Foundation\Facades\Funds;
?>
@if (count(Funds::donationTypes()) > 1)
    <div>
        <span class="text-2xl font-semibold"> {{ __('Donation type') }}</span>
        <div class="grid grid-cols-2 gap-2 mb-5">
            @foreach (Funds::donationTypes() as $key => $type)
                <label
                    class="flex items-center border rounded-lg p-4 mb-2 cursor-pointer "
                    :class="{
                        'border-blue-500': type === @js($key),
                        'border-gray-300': type !== @js($key)
                    }"
                >
                    <input
                        type="radio"
                        name="donation_type"
                        value="{{ $key }}"
                        x-model="type"
                        class="hidden"
                    >
                    <span class="ml-2">{{ $type }}</span>
                    <span
                        x-text="type === '{{ $key }}' ? '✓' : ''"
                        class="ml-auto"
                    ></span>
                </label>
            @endforeach
        </div>
    </div>
@endif
