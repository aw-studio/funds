<x-public::campaign-layout
    :$campaign
    bodyClass="page-select-reward"
>
    <div class="container reward-content-container">
        <section class="col-span-1 mt-8 md:col-span-4">
            <span>
                <a
                    href="{{ route('campaigns.public.show', ['campaign' => $campaign]) }}"
                    class="flex items-center gap-2 mb-4 text-sm text-gray-500"
                >
                    <x-icons.arrow-left />
                    {{ __('Back') }}
                </a>
            </span>
            <div class="mb-4 text-2xl h2">
                {{ __('Choose your reward') }}
            </div>
        </section>
        <div class="grid gap-4 md:grid-cols-3 mb-28">
            <x-public::simple-donation-card :$campaign />
            @foreach ($donation_options as $reward)
                <x-public::reward-donation-card
                    :reward="$reward"
                    :campaign="$campaign"
                />
            @endforeach
        </div>
    </div>
</x-public::campaign-layout>
