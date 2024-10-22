<x-campaigns::layout :campaign="$campaign">
    <form
        method="post"
        enctype="multipart/form-data"
        action="{{ route('campaigns.content.store', ['campaign' => $campaign]) }}"
        x-data
        x-on:keydown.window="if (event.key === 's' && (event.metaKey || event.ctrlKey)) { event.preventDefault();$el.requestSubmit( $refs.submitButton ) }"
    >
        @csrf
        <x-section-headline value="Pitch" />
        <div class="mb-10 w-1/2">
            <x-textarea
                name="description"
                label="Description"
                placeholder="A short description of your campaign"
                rows="3"
                maxlength="125"
            >{{ old('description', $campaign->description ?? '') }}</x-textarea>
        </div>

        <x-input-image
            name="header_image"
            label="Header Image"
            hint="{{ 'The maximum file size is 5 MB. Supported file formats are .jpg and .png.' }}"
            class="w-1/2 mb-10"
            currentUrl="{{ $campaign->getFirstMediaUrl('header_image', 'thumb') }}"
        />
        <x-input-image
            name="intro_image"
            label="Intro Image"
            hint="{{ 'The maximum file size is 5 MB. Supported file formats are .jpg and .png.' }}"
            class="w-1/2 mb-10"
            currentUrl="{{ $campaign->getFirstMediaUrl('intro_image', 'thumb') }}"
        />
        @if ($campaign->getFirstMedia('pitch_video'))
            <video
                controls
                class="w-1/2"
            >
                <source
                    src="{{ $campaign->getFirstMediaUrl('pitch_video') }}"
                    type="video/mp4"
                >
                Your browser does not support the video tag.
            </video>
            <div class="mb-4">
            </div>
        @endif
        <x-input
            name="pitch_video"
            type="file"
        />

        <x-section-headline value="Story" />

        <x-editor
            name="content"
            :content="old('content', $campaign->content ?? '')"
        />

        <x-section-headline
            value="Advanced Settings"
            class="mb-10"
        />
        <div class="font-mono">

            <x-textarea
                name="custom_css"
                style="font-family: 'Courier New', Courier, monospace; font-size: 13px; resize: vertical; font-weight: 600; color: #505050;"
                :value="old('custom_css', $campaign->settings['custom_css'] ?? '')"
                rows="5"
            />
        </div>

        <div>
            <x-button type="submit">
                {{ __('Save') }}
            </x-button>
        </div>
    </form>

</x-campaigns::layout>
