<x-app-layout>
    <x-form-page-container :title="__('Add Reward')">
        <form
            method="POST"
            action="{{ route('rewards.store') }}"
        >
            @csrf
            <div class="mb-4">
                <x-input
                    type="text"
                    name="name"
                    :value="old('name')"
                    :label="__('Name')"
                    placeholder="{{ __('Name') }}"
                />
            </div>
            <div class="mb-4">
                <x-textarea
                    type="text"
                    name="description"
                    :value="old('description')"
                    :label="__('Description')"
                    placeholder="{{ __('Description') }}"
                />
            </div>
            <div class="mb-4">
                <x-input-money
                    name="min_amount"
                    :value="old('min_amount')"
                    :label="__('Min Donation amount')"
                    placeholder="{{ __('Min Donation amount') }}"
                />
            </div>
            <x-button
                outlined
                :href="route('rewards.index')"
            >
                {{ __('Cancel') }}
            </x-button>
            <x-button>
                {{ __('Create Reward') }}
            </x-button>
        </form>
    </x-form-page-container>
</x-app-layout>
