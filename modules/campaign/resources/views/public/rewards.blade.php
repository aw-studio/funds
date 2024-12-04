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
            <x-public::reward-donation-card
                :reward="$reward"
                :campaign="$campaign"
            />
        @endforeach
        <x-public::simple-donation-card :$campaign />
    </div>
</x-public::campaign-layout>
