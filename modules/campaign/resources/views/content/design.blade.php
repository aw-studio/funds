<x-campaign::content-layout :$campaign>

    <div class="max-w-3xl">
        <x-section-headline
            :value="__('Design')"
            class="mb-8
        "
        />
        <p class="text-lg my-2">{{ __('Colors') }}</p>
        <p class="text-gray-600 mb-2 text-sm">Customize the colors and border radius of your campaign.</p>
        <form
            action="{{ route('campaigns.content.style-settings.update', $campaign) }}"
            method="POST"
            x-cloak
            x-data
        >
            @csrf
            <x-campaign::color-settings :campaign="$campaign" />
            <p class="text-lg my-2">{{ __('Advanced Settings') }}</p>
            <p class="text-gray-600 mb-4 text-sm">
                {{ __('Customize the appearance of your campaign by adding custom CSS.') }}
            </p>

            <x-textarea
                name="custom_css"
                label="Custom CSS"
                style="font-family: 'Courier New', Courier, monospace; font-size: 13px; resize: vertical; font-weight: 600; color: #505050;"
                :value="old('custom_css', $campaign->settings['custom_css'] ?? '')"
                placeholder=":root {   }"
                rows="5"
            />

            <div class="border-t border-gray-200 py-8 mt-8 flex justify-end gap-4">
                <x-button
                    outlined
                    href="{{ $campaign->publicRoute() }}"
                    target="_blank"
                >
                    {{ __('View Campaign') }}
                </x-button>
                <x-button type="submit">
                    {{ __('Save') }}
                </x-button>
            </div>
        </form>
        <div>
</x-campaign::content-layout>
