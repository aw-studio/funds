<x-public::campaign-layout :$campaign>
    <div class="my-24 flex justify-center items-center">
        <div class="flex flex-col items-ceter justify-center text-center">
            @if ($status == 'failed')
                <x-donation::icons.donation-failed class="mx-auto mb-8" />
                <h1 class="text-3xl mb-6">{{ __('Oops, something went wrong') }}</h1>
                <p class="mb-12">{{ __('Something went wrong with your donation') }}</p>
            @else
                <x-donation::icons.donation-succeeded class="mx-auto mb-8" />
                <h1 class="text-3xl mb-6">{{ __('Thank you for supporting our campaign.') }}</h1>
                @if ($status == 'pending')
                    <p class="mb-6">
                        {{ __('Your donation is pending.') }}
                        {{ __('We will notify you as soon as it is confirmed.') }}
                    </p>
                @else
                    <p class="mb-6">
                        {{ __('We\'ve received your donation.') }}
                        {{ __('You will receive a confirmation email shortly.') }}
                    </p>
                @endif
            @endif
            <a
                class="inline-block fc-button mx-auto"
                href="{{ route('campaigns.public.show', $campaign) }}"
            >{{ __('Back to campaign') }}</a>
        </div>
    </div>
</x-public::campaign-layout>
