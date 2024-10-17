<x-campaigns::public.campaign-layout :$campaign>
    @if ($headerImage = $campaign->getFirstMediaUrl('header_image'))
        <div class="h-96 mb-10">
            <img
                src="{{ $headerImage }}"
                alt="{{ $campaign->name }}"
                class="w-full h-96 object-cover"
            >
        </div>
    @endif
    <section class="grid md:grid-cols-2 gap-8  mb-10">
        @if ($pitchVideo = $campaign->getFirstMedia('pitch_video'))
            <x-campaigns::public.pitchVideo
                :video="$pitchVideo"
                :$campaign
            />
        @elseif ($introImage = $campaign->getFirstMediaUrl('intro_image'))
            <div>
                {{ $campaign->getFirstMedia('intro_image') }}
                {{-- <img
                    src="{{ $campaign->getFirstMediaUrl('intro_image') }}"
                    alt="{{ $campaign->name }}"
                    class="image-radius w-full" --}}
                {{-- > --}}
            </div>
        @endif
        <div>
            <h1 class="text-3xl mb-4">{{ $campaign->name }}</h1>
            <p class="mb-4">{{ $campaign->description ?? '' }}</p>

            <p class="mb-2">{{ __('Campaign goal') }}</p>
            <p class="text-2xl">
                {{ $campaign->totalAmountDonated() }} /
                {{ $campaign->goal }}</p>
            <div class="bg-gray-200 w-full h-3 my-4 progress-bar">
                <div
                    @class([
                        'h-3 bg-accent-1 rounded-l progress',
                        'rounded' => $campaign->progress() > 99,
                    ])
                    style="width: {{ $campaign->progress() }}%;"
                ></div>
            </div>
            <p class="mb-8">
                {{ $campaign->donations_count }} {{ __('Supporters') }}
            </p>

            <a
                href="{{ route('public.checkout', ['campaign' => $campaign]) }}"
                class="fc-button"
            >
                {{ __('Support now') }}
            </a>
        </div>

        <div class="col-span-full">
            @lang('Share this campaign')
            <x-campaigns::public.share-icons />
        </div>
    </section>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
        <div class="col-span-1 md:col-span-8 ">
            <x-campaigns::tabs>
                <x-slot name="buttons">
                    <x-campaigns::tab-button
                        index="0"
                        aria-selected="true"
                    >Story</x-campaigns::tab-button>
                    @if ($faqs->count())
                        <x-campaigns::tab-button index="1">FAQ</x-campaigns::tab-button>
                    @endif
                </x-slot>
                <x-slot name="panels">
                    <x-campaigns::tab-item index="0">
                        <div class="prose my-8">
                            {!! $campaign->renderedContent !!}
                        </div>
                    </x-campaigns::tab-item>
                    @if ($faqs->count())
                        <x-campaigns::tab-item index="1">
                            <div class="my-8 prose">
                                <h2>FAQ</h2>
                                @foreach ($faqs as $faq)
                                    <h3>{{ $faq->question }}</h3>
                                    <p>{{ $faq->answer }}</p>
                                @endforeach
                            </div>
                        </x-campaigns::tab-item>
                    @endif
                </x-slot>
            </x-campaigns::tabs>
        </div>
        <div class="col-span-1 md:col-span-4 bg-accent-2 p-4 card-radius">
            <div class="text-accent-2 mb-4 text-2xl">
                {{ __('Choose a reward') }}
            </div>
            @foreach ($donation_options as $reward)
                <x-campaigns::public.donation-card>
                    <div class="w-full mb-2">
                        {{ $reward->getFirstMedia('image') }}
                    </div>
                    <div class="flex gap-2 mb-2">
                        <div class="tag text-sm p-1 px-2 bg-accent-2 text-accent-2">
                            {{ $reward->min_amount }}
                        </div>
                        <p class="text-lg">
                            {{ $reward->name }}
                        </p>
                    </div>
                    <p class="mb-4">
                        {{ $reward->description }}
                    </p>
                    <div class="text-right">
                        <a
                            href="{{ route('public.checkout', ['campaign' => $campaign, 'reward' => $reward]) }}"
                            class="text--general-color underline underline-offset-4 text-accent-1"
                        >
                            {{ __('Select and Continue') }}
                        </a>
                    </div>
                </x-campaigns::public.donation-card>
            @endforeach
            <x-campaigns::public.donation-card>
                <div class="flex gap-2 mb-2">
                    <p class="text-lg">
                        {{ 'Simple Donation' }}
                    </p>
                </div>
                {{-- <x-input /> --}}
                <p class="mb-4">
                    {{ 'Support us with a donation of any amount for nothing in return!' }}
                </p>
                <div class="text-right">
                    <a
                        href="{{ route('public.checkout', ['campaign' => $campaign]) }}"
                        class="text--general-color underline underline-offset-4 text-accent-1"
                    >
                        {{ __('Donate now') }}
                    </a>
                </div>

            </x-campaigns::public.donation-card>
        </div>
    </div>
</x-campaigns::public.campaign-layout>
