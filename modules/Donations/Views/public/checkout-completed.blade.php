<x-public::campaign-layout :$campaign>
    <div class="text-center my-24">
        @if ($status == 'failed')
            <h1 class="text-4xl mb-6">{{ __('Oops, something went wrong.') }}</h1>
            <p>{{ __('Something went wrong with your donation.') }}</p>
        @else
            <h1 class="text-4xl mb-6">{{ __('Thank you for supporting our campaign.') }}</h1>
            <p>{{ __('We\'ve received your donation.') }}</p>
        @endif
        <a
            class="inline-block fc-button"
            href="{{ route('campaigns.public.show', $campaign) }}"
        >{{ __('Back to campaign') }}</a>
    </div>
</x-public::campaign-layout>
