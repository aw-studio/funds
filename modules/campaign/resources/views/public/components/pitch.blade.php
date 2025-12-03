@php
    $pitchVideo = $campaign->getFirstMedia('pitch_video');
    $pitchYoutube = $campaign->youtube_id;
    if (!$pitchVideo) {
        $pitchImage = $campaign->getFirstMedia('intro_image');
    }

    $hasPitchImageOrVideo = $pitchVideo || $pitchImage || !empty($campaign->youtube_id);
@endphp

<x-public::layout-header />

<div class="relative mb-8">
    @if ($headerImage = $campaign->getFirstMediaUrl('header_image'))
        <div
            class="absolute top-0 left-0 w-screen h-full"
            style="background: #15222c"
        >
            <img
                src="{{ $headerImage }}"
                alt="{{ $campaign->name }}"
                class="object-cover w-full h-full opacity-15 "
            >
        </div>
    @endif
    <div class="container pt-16 pb-4 pitch-container">
        <section class="relative grid gap-8 mb-10 text-white md:grid-cols-2 md:gap-12 pitch">

            @if ($pitchYoutube)
                <iframe
                    src="https://www.youtube.com/embed/{{ $pitchYoutube }}"
                    title="{{ $campaign->name }}"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin"
                    allowfullscreen
                    class="w-full aspect-video"
                ></iframe>
            @elseif ($pitchVideo)
                <x-public::pitch-video
                    :video="$pitchVideo"
                    :$campaign
                />
            @elseif ($pitchImage)
                <div>
                    {{ $pitchImage->img()->attributes(['class' => 'aspect-video object-cover']) }}
                </div>
            @endif
            <div @class([
                'col-span-full grid grid-cols-2' => !$hasPitchImageOrVideo,
                'col-span-1 flex flex-col' => $hasPitchImageOrVideo,
            ])>
                <div>
                    <h1 class="mb-4 text-3xl">{{ $campaign->name }}</h1>
                    <p class="mb-4">{{ $campaign->description ?? '' }}</p>
                </div>

                <div class="flex flex-col justify-end flex-1">
                        @if ($campaign->showDonationProgress())
                        <p class="mb-2">
                            {{ __('Donation goal') }}
                        </p>
                        <p class="text-2xl">
                            {{ $campaign->totalAmountDonated() }} /
                            {{ $campaign->goal }} erreicht
                        </p>
                        <x-public::progress-bar :$campaign />
                        @endif
                        <p class="mt-3 mb-8">
                            @if ($campaign->totalAmountDonated() < $campaign->goal)
                                {{ $campaign->donations_count }} {{ __('Supporters') }}
                            @else
                                {{ __('Goal reached', [
                                    'donations_count' => $campaign->donations_count,
                                ]) }}
                            @endif
                        </p>
                        @if ($campaign->isRunning())
                            <div class="flex flex-wrap gap-3">
                                <a
                                    href="{{ route('campaigns.public.rewards', ['campaign' => $campaign]) }}"
                                    class="inline-block fc-button"
                                >
                                    {{ __('Donate now') }}
                                </a>
                                <a
                                    href="https://politicalbeauty.de/spenden.html"
                                    class="inline-block fc-button-secondary"
                                    target="_blank"
                                >
                                    Fördermitglied werden
                                </a>
                            </div>
                        @endif
                </div>

            </div>
            <div class="col-span-full">
                <p class="mb-3">@lang('Share this campaign')</p>
                <x-public::share-icons :$campaign />
            </div>
            @auth
                <a
                    href="{{ route('campaigns.content.pitch.edit', ['campaign' => $campaign]) }}"
                    class="absolute bottom-0 right-0 inline-flex items-center gap-2 text-sm underline"
                >
                    {{ __('Edit Pitch') }}<x-icons.pencil class="w-4 h-4" />
                </a>
            @endauth
        </section>
    </div>
</div>
