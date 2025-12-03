<x-campaign::content-layout :$campaign>
    <x-section-headline
        value="Pitch"
        class="mb-8"
    />
    <form
        class="max-w-prose"
        method="post"
        enctype="multipart/form-data"
        action="{{ route('campaigns.content.pitch.store', ['campaign' => $campaign]) }}"
    >
        @csrf
        <p class="text-lg">
            {{ __('Header') }}
        </p>
        <p class="mb-4 text-xs text-gray-500">
            {{ __('You can add an image that will be visible at the top of the campaign page.') }}
        </p>
        <x-input-image
            name="header_image"
            label="Upload Image"
            hint="{{ 'The maximum file size is 5 MB. Supported file formats are .jpg and .png.' }}"
            class="mb-10 md:max-w-sm"
            currentUrl="{{ $campaign->getFirstMediaUrl('header_image', 'thumb') }}"
        />
        <div class="mb-10 ">

            <p class="text-lg">
                {{ __('Description') }}
            </p>
            <p class="mb-4 text-xs text-gray-500">
                {{ __('The campaign is presented here in a short text.') }}
            </p>
            <x-textarea
                name="description"
                label="Text"
                placeholder="A short description of your campaign"
                rows="3"
                maxlength="250"
            >{{ old('description', $campaign->description ?? '') }}</x-textarea>
        </div>

        <div>
            <p class="text-lg">
                {{ __('Cover picture or video') }}
            </p>
            <p class="mb-4 text-xs text-gray-500">
                {{ __('Upload an image or a video that represents your campaign.') }}
            </p>

            @php
                $pitchYoutube = $campaign->youtube_id;
                $pitchVideo = $campaign->getFirstMedia('pitch_video');
            @endphp
            <div x-data="{ openTab: @js($pitchYoutube ? 3 : ($pitchVideo ? 2 : 1)) }">
                <div class="inline-flex gap-1 p-1 mb-4 text-gray-500 rounded-lg bg-gray-50">
                    <button
                        type="button"
                        x-on:click="openTab = 3"
                        :class="{ 'bg-white text-black': openTab === 3 }"
                        class="flex-1 px-4 py-1 rounded-md focus:outline-none "
                    >{{ __('Youtube') }}</button>
                    <button
                        type="button"
                        x-on:click="openTab = 1"
                        :class="{ 'bg-white text-black': openTab === 1 }"
                        class="flex-1 px-4 py-1 rounded-md focus:outline-none "
                    >{{ __('Image') }}</button>
                    <button
                        type="button"
                        x-on:click="openTab = 2"
                        :class="{ 'bg-white text-black': openTab === 2 }"
                        class="flex-1 px-4 py-1 rounded-md focus:outline-none "
                    >{{ __('Video') }}</button>
                    
                </div>

                <div
                    x-show="openTab === 1"
                    @if ($pitchVideo) x-cloak @endif
                    class="transition-all duration-300"
                >
                    <x-input-image
                        name="intro_image"
                        :label="__('Upload pitch image')"
                        hint="{{ 'The maximum file size is 5 MB. Supported file formats are .jpg and .png.' }}"
                        class="mb-10 md:max-w-sm"
                        currentUrl="{{ $campaign->getFirstMediaUrl('intro_image', 'thumb') }}"
                    />
                </div>

                <div
                    x-show="openTab === 2"
                    class="transition-all duration-300 "
                    @if (!$pitchVideo) x-cloak @endif
                >
                    @if ($pitchVideo)
                        <div class="block p-4 rounded-md bg-gray-50">
                            <img src="{{ $pitchVideo->getUrl('thumb') }}" />
                            {{ $pitchVideo->file_name }}
                        </div>
                    @endif
                    <div class="relative flex flex-col w-full max-w-sm gap-1">
                        <label
                            class="w-fit pl-0.5 text-sm text-slate-700 "
                            for="fileInput"
                        >Pitch Video</label>
                        <input
                            id="fileInput"
                            type="file"
                            name="pitch_video"
                            class="w-full mb-4 text-sm text-gray-700 border border-gray-200 overflow-clip rounded-xl bg-gray-50 file:mr-4 file:cursor-pointer file:border-none file:bg-gray-100 file:px-4 file:py-2 file:font-medium file:text-black focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-purple-700 disabled:cursor-not-allowed disabled:opacity-75"
                        />
                    </div>
                </div>

                <div
                    x-show="openTab === 3"
                    class="transition-all duration-300 "
                    @if (!$campaign->youtube_id) x-cloak @endif
                >
                    <x-input
                        type="text"
                        name="youtube_id"
                        :label="__('YouTube Video ID')"
                        placeholder="Trage hier die YouTube Video ID ein (e.g. bkeHhx3BlcY)"
                        class="md:max-w-sm"
                        value="{{ old('youtube_id', $campaign->youtube_id ?? '') }}"
                    />  

                </div>

        </div>
        <div class="mb-4">
            <p class="text-lg">
                {{ __('Display donation progress') }}
            </p>
            <p class="mb-4 text-xs text-gray-500">
                {{ __('The campaign\'s donation target and the amount already donated are displayed.') }}
            </p>
            <div class="flex items-center gap-2">
                <x-input-toggle
                    size="sm"
                    name="show_progress"
                    :checked="old('show_progress', $campaign->settings['show_progress'] ?? true)"
                    :label="__('Show progress')"
                />
            </div>
        </div>
        <div class="mt-16 mb-4">
            <p class="text-lg">
                {{ __('Sharing') }}
            </p>
            <p class="mb-4 text-xs text-gray-500">
                {{ __('OG and Twitter images used for sharing on social media.') }}
            </p>
            <x-input-image
                name="og_image"
                label="Upload Image"
                hint="{{ 'The maximum file size is 5 MB. Supported file formats are .jpg and .png.' }}"
                class="mb-10 md:max-w-sm"
                currentUrl="{{ $campaign->getFirstMediaUrl('og_image', 'thumb') }}"
            />
            <x-input-image
                name="twitter_image"
                label="Upload Image"
                hint="{{ 'The maximum file size is 5 MB. Supported file formats are .jpg and .png.' }}"
                class="mb-10 md:max-w-sm"
                currentUrl="{{ $campaign->getFirstMediaUrl('twitter_image', 'thumb') }}"
            />
        </div>

        <div class="flex justify-end gap-4 py-8 border-t border-gray-200">
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
</x-campaign::content-layout>
