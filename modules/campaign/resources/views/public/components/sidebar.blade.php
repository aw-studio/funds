@props(['donation_options' => [], 'campaign' => null])
<div class="col-span-1 md:col-span-4">
    <div class= "p-8 sidebar">
        <div class="mb-4 text-2xl">
            {{ __('Choose your reward') }}
        </div>
        @foreach ($donation_options as $reward)
            <x-public::reward-donation-card
                :reward="$reward"
                :campaign="$campaign"
                class="mb-5"
            />
        @endforeach
        <x-public::simple-donation-card :$campaign />
    </div>
</div>
