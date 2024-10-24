@php
    $pitchVideo = $campaign->getFirstMedia('pitch_video');
    if (!$pitchVideo) {
        $pitchImage = $campaign->getFirstMedia('intro_image');
    }

    $hasPitchImageOrVideo = $pitchVideo || $pitchImage;
@endphp
<section class="grid md:grid-cols-2 gap-8 mb-10 pitch">
    @if ($headerImage = $campaign->getFirstMediaUrl('header_image'))
        <div class="h-96 col-span-full mb-10">
            <img
                src="{{ $headerImage }}"
                alt="{{ $campaign->name }}"
                class="w-full h-96 object-cover"
            >
        </div>
    @endif

    @if ($pitchVideo)
        <x-public::pitch-video
            :video="$pitchVideo"
            :$campaign
        />
    @elseif ($pitchImage)
        <div>
            {{ $pitchImage }}
        </div>
    @endif
    <div @class([
        'col-span-full grid grid-cols-2' => !$hasPitchImageOrVideo,
        'col-span-1' => $hasPitchImageOrVideo,
    ])>
        <div>
            <h1 class="text-3xl mb-4">{{ $campaign->name }}</h1>
            <p class="mb-4">{{ $campaign->description ?? '' }}</p>
        </div>

        <div>
            <p class="mb-2">{{ __('Campaign goal') }}</p>
            <p class="text-2xl">
                {{ $campaign->totalAmountDonated() }} /
                {{ $campaign->goal }}
            </p>
            <x-public::progress-bar :$campaign />
            <p class="mb-8">
                {{ $campaign->donations_count }} {{ __('Supporters') }}
            </p>

            @if ($campaign->isRunning())
                <a
                    href="{{ route('campaigns.public.rewards', ['campaign' => $campaign]) }}"
                    class="fc-button inline-block"
                >
                    {{ __('Support now') }}
                </a>
            @endif
        </div>

    </div>
    <div class="col-span-full">
        @lang('Share this campaign')
        <x-public::share-icons />
    </div>
</section>
