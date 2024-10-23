@props(['donation_options' => [], 'campaign' => null])
<div class="col-span-1 md:col-span-4 p-4 sidebar">
    <div class="mb-4 text-2xl">
        {{ __('Choose a reward') }}
    </div>
    @foreach ($donation_options as $reward)
        <x-public::donation-card>
            <div class="w-full mb-2">
                {{ $reward->getFirstMedia('image') }}
            </div>
            <div class="flex gap-2 mb-2">
                <div class="tag text-sm p-1 px-2">
                    {{ $reward->min_amount }}
                </div>
                <p class="title text-lg">
                    {{ $reward->name }}
                </p>
            </div>
            <p class="description mb-4">
                {{ $reward->description }}
            </p>
            <div class="text-right">
                <a
                    href="{{ route('public.checkout', ['campaign' => $campaign, 'reward' => $reward]) }}"
                    class="button-link underline underline-offset-4"
                >
                    {{ __('Select and Continue') }}
                </a>
            </div>
        </x-public::donation-card>
    @endforeach
    <x-public::donation-card>
        <div class="flex gap-2 mb-2">
            <p class="title text-lg">
                {{ 'Simple Donation' }}
            </p>
        </div>
        <p class="description mb-4">
            {{ 'Support us with a donation of any amount for nothing in return!' }}
        </p>
        <div class="text-right">
            <a
                href="{{ route('public.checkout', ['campaign' => $campaign]) }}"
                class="button-link underline underline-offset-4"
            >
                {{ __('Donate now') }}
            </a>
        </div>
    </x-public::donation-card>
</div>
