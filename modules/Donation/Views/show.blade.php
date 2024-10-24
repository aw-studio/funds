<x-app-layout :backLink="route('donations.index')">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-serif">
            @lang('Donation') #{{ $donation->id }}
        </h2>
        <hr class="mt-4 mb-8" />
        <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
            <x-donation::show.details :$donation />
            <div class="flex flex-col gap-8">
                <x-donation::show.donor :$donation />
                <x-donation::show.type :$donation />
                @stack('widgets')
            </div>
        </div>
</x-app-layout>
