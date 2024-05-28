<x-campaigns::public.layout title="{{ $campaign->name }}">
    <div class="text-center my-24">
        <h1 class="text-4xl mb-6">{{ __('Thank you for supporting our campaign.') }}</h1>
        <p>{{ __('We\'ve received your donation.') }}</p>
        <a
            class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded mt-10 inline-block"
            href="{{ route('public.campaigns.show', $campaign) }}"
        >{{ __('Back to campaign') }}</a>
    </div>
</x-campaigns::public.layout>
