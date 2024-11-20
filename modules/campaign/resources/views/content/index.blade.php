<x-campaign::content-layout :campaign="$campaign">
    <x-section-headline
        value="Story"
        class="mb-8"
    />

    <form
        class="max-w-3xl"
        method="post"
        enctype="multipart/form-data"
        action="{{ route('campaigns.content.story.store', ['campaign' => $campaign]) }}"
        x-data
        x-on:keydown.window="if (event.key === 's' && (event.metaKey || event.ctrlKey)) { event.preventDefault();$el.requestSubmit( $refs.submitButton ) }"
    >
        @csrf

        <x-editor
            name="content"
            :content="old('content', $campaign->content ?? '')"
        />

        <div class="border-t border-gray-200 flex justify-end gap-4 py-8">
            <x-button
                type="button"
                outlined
                :href="$campaign->publicRoute()"
                target="_blank"
            >
                {{ __('View Campaign') }}
            </x-button>
            <x-button type="submit">
                {{ __('Save') }}
            </x-button>
        </div>
    </form>

</x-campaign::content-layout>
