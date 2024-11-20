<x-app-layout :title="page_title(__('Add Donation'))">
    @php
        $cancelRoute = url()->previous();
        $previousRoute = url()->previous();

        if (str($previousRoute)->contains('login') || str($previousRoute)->contains('donations/create')) {
            $cancelRoute = route('campaigns.show', ['campaign' => $campaign]);
        }

    @endphp
    <x-form-page-container :title="__('Add Donation')">
        <form
            method="POST"
            action="{{ route('donations.store') }}"
        >
            @csrf
            <div class="mb-4">
                <x-input
                    type="email"
                    name="email"
                    :label="__('Email')"
                    :value="old('email')"
                    placeholder="Email"
                />
            </div>
            <div class="mb-4">
                <x-input-money
                    name="amount"
                    :label="__('Donation Amount')"
                    :value="old('amount')"
                    placeholder="Amount"
                />
            </div>
            <x-button
                outlined
                :href="$cancelRoute"
                wire:navigate
            >
                {{ __('Cancel') }}
            </x-button>
            <x-button type="submit">
                {{ __('Add Donation') }}
            </x-button>
        </form>
        </x-container>
</x-app-layout>
