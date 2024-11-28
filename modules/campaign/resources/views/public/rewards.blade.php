<x-public::campaign-layout
    :$campaign
    bodyClass="page-select-reward"
>
    <section class="col-span-1 md:col-span-4 mt-8">
        <span>
            <a
                href="{{ route('campaigns.public.show', ['campaign' => $campaign]) }}"
                class="flex items-center text-sm text-gray-500 gap-2 mb-4"
            >
                <x-icons.arrow-left />
                {{ __('Back') }}
            </a>
        </span>
        <div class="h2 mb-4 text-2xl">
            {{ __('Choose your reward') }}
        </div>
    </section>
    <div class="grid md:grid-cols-3 gap-4 mb-28">
        @foreach ($donation_options as $reward)
            <x-public::donation-card
                :href="route('public.checkout', ['campaign' => $campaign, 'reward' => $reward])"
                @endif :disabled="!$reward->isAvailable()">
                @if ($image = $reward->getFirstMedia('image'))
                    <div class="w-full mb-2">
                        {{ $image }}
                    </div>
                @endif
                <div class="flex gap-2 mb-2">
                    <div class="tag self-start text-sm p-1 px-2">
                        {{ $reward->min_amount }}
                    </div>
                    <p class="title text-lg">
                        {{ $reward->name }}
                    </p>
                </div>
                <p class="description mb-3 text-muted">
                    {{ $reward->description }}
                </p>
                <div class="text-right">
                    <span class="button-link underline underline-offset-8">
                        {{ __('Select and Continue') }}
                    </span>
                </div>
            </x-public::donation-card>
        @endforeach
        <x-public::donation-card href="{{ route('public.checkout', ['campaign' => $campaign]) }}">

            <div class="flex gap-2 mb-2">
                <p class="title text-lg">
                    {{ __('Simple Donation') }}
                </p>
            </div>
            <x-input
                type="text"
                name="amount"
                value="5 €"
                disabled
                class="pointer-events-none mb-3"
            />
            <p class="description mb-3 text-muted">
                {{ __('Support us with a donation of any amount for nothing in return!') }}
            </p>
            <div class="text-right">
                <span class="button-link underline underline-offset-8">
                    {{ __('Donate an amount') }}
                </span>
            </div>
        </x-public::donation-card>
    </div>
</x-public::campaign-layout>
