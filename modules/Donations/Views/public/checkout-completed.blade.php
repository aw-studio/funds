<x-campaigns::public.campaign-layout :$campaign>
    <div class="text-center my-24">
        @env('local')
        {{ $status }}
        @endenv
        @if ($status == 'failed')
            <h1 class="text-4xl mb-6">{{ __('Oops, something went wrong.') }}</h1>
            <p>{{ __('Something went wrong with your donation.') }}</p>
        @else
            <h1 class="text-4xl mb-6">{{ __('Thank you for supporting our campaign.') }}</h1>
            <p>{{ __('We\'ve received your donation.') }}</p>
        @endif
        <a
            class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded mt-10 inline-block"
            href="{{ route('public.campaigns.show', $campaign) }}"
        >{{ __('Back to campaign') }}</a>
    </div>
</x-campaigns::public.campaign-layout>
