<x-app-layout :title="page_title(__('Edit Donor Details'))">
    <x-form-page-container :title="__('Edit Donor Details')">
        <form
            action="{{ route('donors.update', $donor) }}"
            method="POST"
            class="space-y-4"
        >
            @csrf
            @method('PUT')
            <x-input
                label="Name"
                name="name"
                value="{{ $donor->name }}"
                required
            />
            <x-input
                label="Email"
                name="email"
                value="{{ $donor->email }}"
                required
            />
            <div class="my-10">
                <x-button
                    outlined
                    :href="$cancelRoute"
                    wire:navigate
                >
                    {{ __('Cancel') }}
                </x-button>
                <x-button type="submit">
                    {{ __('Save') }}
                </x-button>
            </div>

        </form>
    </x-form-page-container>
</x-app-layout>
