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
        @if ($pitchVideo = $campaign->getFirstMedia('pitch_video'))
            <div class=" bg-gray-50 rounded-md block p-4">
                <img src="{{ $pitchVideo->getUrl('thumb') }}" />
                {{ $pitchVideo->file_name }}
            </div>
        @endif
        <div class="relative flex w-full max-w-sm flex-col gap-1">
            <label
                class="w-fit pl-0.5 text-sm text-slate-700 "
                for="fileInput"
            >Pitch Video</label>
            <input
                id="fileInput"
                type="file"
                name="pitch_video"
                class="w-full overflow-clip rounded-xl border border-slate-300 bg-slate-100/50 text-sm text-slate-700 file:mr-4 file:cursor-pointer file:border-none file:bg-slate-100 file:px-4 file:py-2 file:font-medium file:text-black focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700 disabled:cursor-not-allowed disabled:opacity-75 "
            />
        </div>

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
                label="Custom CSS"
                style="font-family: 'Courier New', Courier, monospace; font-size: 13px; resize: vertical; font-weight: 600; color: #505050;"
                :value="old('custom_css', $campaign->settings['custom_css'] ?? '')"
                placeholder=":root {   }"
                rows="5"
            />

        </div>
        <x-campaigns::style-settings :campaign="$campaign" />
        <div>
            <x-button type="submit">
                {{ __('Save') }}
            </x-button>
        </div>
    </form>

    <x-section-headline value="FAQs" />
    <div>
        <livewire:faqs :campaign="$campaign" />
    </div>

</x-campaigns::layout>
