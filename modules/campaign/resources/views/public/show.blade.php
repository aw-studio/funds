<x-public::campaign-layout
    :$campaign
    :header="false"
>
    <x-public::pitch :$campaign />
    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
        <div class="col-span-1 md:col-span-8 ">
            <x-campaign::tabs>
                <x-slot name="buttons">
                    <x-campaign::tab-button
                        index="0"
                        aria-selected="true"
                    >Story</x-campaign::tab-button>
                    @if ($faqs->count())
                        <x-campaign::tab-button index="1">FAQ</x-campaign::tab-button>
                    @endif
                </x-slot>
                <x-slot name="panels">
                    <x-campaign::tab-item index="0">
                        <div class="prose my-8">
                            {!! $campaign->renderedContent !!}
                        </div>
                        @auth
                            <a
                                href="{{ route('campaigns.content.story.edit', ['campaign' => $campaign]) }}"
                                class="inline-flex gap-2 items-center underline text-sm text-gray-700"
                            >
                                {{ __('Edit Story') }}<x-icons.pencil class="w-4 h-4 stroke-current" />
                            </a>
                        @endauth
                    </x-campaign::tab-item>
                    @if ($faqs->count())
                        <x-campaign::tab-item index="1">
                            <div class="my-8 prose">
                                <x-public::faqs :$faqs />
                            </div>
                        </x-campaign::tab-item>
                    @endif
                </x-slot>
            </x-campaign::tabs>
        </div>
        <x-public::sidebar
            :donation_options="$donation_options"
            :$campaign
        />
    </div>
</x-public::campaign-layout>
