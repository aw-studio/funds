<x-public::campaign-layout
    :$campaign
    bodyClass="bg-accent-2"
>
    <section class="col-span-1 md:col-span-4">
        <span>
            <a
                href="{{ route('campaigns.public.show', ['campaign' => $campaign]) }}"
                class="text-accent-1 text-sm"
            >
                {{ __('Back') }}
            </a>
        </span>
        <div class="text-accent-2 mb-4 text-2xl">
            {{ __('Choose your reward') }}
        </div>
    </section>
    <div class="grid md:grid-cols-3 gap-4">
        @foreach ($donation_options as $reward)
            <x-public::donation-card>
                <div class="flex gap-2 mb-2">
                    <div class="rounded-lg  text-sm p-1 px-2 bg-accent-2 text-accent-2">
                        {{ $reward->min_amount }}
                    </div>
                    <p class="text-lg">
                        {{ $reward->name }}
                    </p>
                </div>
                <p class="mb-4">
                    {{ $reward->description }}
                </p>
                <div class="text-right">
                    <a
                        href="{{ route('public.checkout', ['campaign' => $campaign, 'reward' => $reward]) }}"
                        class="text--general-color underline underline-offset-4 text-accent-1"
                    >
                        {{ __('Select and Continue') }}
                    </a>
                </div>
            </x-public::donation-card>
        @endforeach
    </div>
</x-public::campaign-layout>
