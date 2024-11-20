<x-campaign::layout backRoute="{{ $campaign->appRoute() }}">
    <livewire:donations-listing :campaign="$campaign" />

    @if ($pendingDonationsCount > 0)
        {{-- <a
            class="p-4 text-center block"
            href="{{ route('donations.intents.index') }}"
        >
            {{ __('Pending Donations') }}: {{ $pendingDonationsCount }}
        </a> --}}
    @endif
</x-campaign::layout>
