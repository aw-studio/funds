<x-campaign-layout backRoute="{{ $campaign->appRoute() }}">
    {{-- <h2 class="text-2xl font-serif  font-bold text-gray-800 dark:text-gray-200">
        {{ __('Donation Intents') }}
    </h2> --}}
    <div class="p-6 text-gray-900 dark:text-gray-100">
        @foreach ($intents as $intent)
            <a
                href="{{ route('donations.intents.show', $intent) }}"
                class="flex items-center justify-between mb-4 border-b border-gray-200 dark:border-gray-700 py-2"
            >
                <div class="">
                    {{ new \Funds\Core\Support\Amount($intent->amount) }}
                </div>
                <div class="">
                    {{ $intent->email }}
                </div>
                <div class="">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $intent->type }}
                    </p>
                </div>
                <div class="">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $intent->status }}
                    </p>
                </div>
                <div class="ml-4">

                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $intent->created_at->diffForHumans() }}
                    </p>
                </div>
            </a>
        @endforeach
    </div>
    </div>

</x-campaign-layout>
