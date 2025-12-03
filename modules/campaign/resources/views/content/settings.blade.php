<x-campaign::content-layout :$campaign>

    <x-section-headline
        value="Settings"
        class="mb-8"
    />

    <form
        action="{{ route('campaigns.content.settings.update', $campaign) }}"
        method="POST"
    >
        @csrf

            <h3 class="text-lg font-medium mb-4">SEO & Social Media</h3>

            <div class="mb-4">
                <x-textarea
                    name="meta_description"
                    :label="__('META Description')"
                    :value="$campaign->meta_description"
                    placeholder="Kurze Beschreibung für Suchmaschinen (max. 160 Zeichen empfohlen)"
                    rows="3"
                />
                <p class="text-sm text-gray-500 mt-2">
                    Diese Beschreibung wird in Suchmaschinenergebnissen angezeigt.
                </p>
            </div>

            <div class="mb-4">
                <x-textarea
                    name="social_share_text"
                    :label="__('Social Media Share Text')"
                    :value="$campaign->social_share_text"
                    placeholder="Text für Social Media Shares"
                    rows="3"
                />
                <p class="text-sm text-gray-500 mt-2">
                    Dieser Text wird verwendet, wenn die Kampagne auf Social Media geteilt wird.
                </p>
            </div>

        <div class="flex gap-4">
            <x-button type="submit">
                {{ __('Save Settings') }}
            </x-button>
        </div>
    </form>

</x-campaign::content-layout>
