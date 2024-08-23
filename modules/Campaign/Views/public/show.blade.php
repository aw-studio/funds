<x-campaigns::public.layout :$campaign>
    @if ($headerImage = $campaign->getFirstMediaUrl('header_image'))
        <div class="h-96 mb-10">
            <img
                src="{{ $headerImage }}"
                alt="{{ $campaign->name }}"
                class="w-full h-96 object-cover"
            >
        </div>
    @endif
    <div class="grid grid-cols-1 md:grid-cols-4">
        <div class="col-span-1 md:col-span-3">
            <h1 class="font-semibold text-2xl">
                {{ $campaign->name ?? 'Foo' }}
            </h1>
            <div>
                Goal: {{ $campaign->goal }}
            </div>
            <div class="mt-8">
                {{ new \Illuminate\Support\HtmlString(nl2br($campaign->content)) }}
            </div>
        </div>
        <div class="col-span-1 md:col-span-1">
            @foreach ($campaign->rewards as $reward)
                <div class="border-4 border-dashed border-gray-200 rounded-lg h-48 mb-10">
                    <h2 class="font-semibold text-xl">
                        {{ $reward->name }}
                    </h2>
                    <p>
                        {{ $reward->description }}
                    </p>
                    <p>
                        {{ $reward->min_amount }}
                    </p>
                    <a
                        href="{{ route('public.checkout', ['campaign' => $campaign, 'reward' => $reward]) }}"
                        class="bg-primary text-white font-bold py-2 px-4 rounded"
                    >
                        {{ __('Select and Continue') }}
                    </a>
                </div>
            @endforeach
            <div class="border-4 border-dashed border-gray-200 rounded-lg h-48 mb-10">
                <a
                    href="{{ route('public.checkout', ['campaign' => $campaign]) }}"
                    class="bg-primary text-white font-bold py-2 px-4 rounded"
                >
                    {{ __('Support without reward') }}
                </a>
            </div>
        </div>
    </div>
</x-campaigns::public.layout>
