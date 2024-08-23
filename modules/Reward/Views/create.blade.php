<x-campaign-layout>
    <form
        method="POST"
        action="{{ route('rewards.store') }}"
    >
        @csrf
        <div class="mt-4">
            <x-input-label
                for="name"
                :value="__('Name')"
            />

            <x-input
                type="text"
                name="name"
                placeholder="{{ __('Name') }}"
            />

            <x-input-error
                :messages="$errors->get('form.name')"
                class="mt-2"
            />
        </div>

        <x-input
            type="text"
            name="description"
            placeholder="{{ __('Description') }}"
        />
        <x-input
            type="number"
            name="min_amount"
            placeholder="{{ __('Min Donation amount') }}"
        />
        <x-button>
            {{ __('Create') }}
        </x-button>
    </form>
</x-campaign-layout>
