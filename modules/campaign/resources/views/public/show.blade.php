<x-public::campaign-layout
    :$campaign
    :header="false"
>
    <x-public::pitch :$campaign />
    <div class="md:container content-container">
        <div class="flex flex-col-reverse gap-8 md:grid md:grid-cols-12">
            <div class="col-span-1 md:col-span-8">
                <div class="container md:!px-0 md:max-w-none md:mx-0 ">

                    <x-campaign::tabs>
                        <x-slot name="buttons">
                            <x-campaign::tab-button
                                index="0"
                                aria-selected="true"
                                slug="story"
                            >
                                Info
                            </x-campaign::tab-button>
                            @if ($faqs->count())
                                <x-campaign::tab-button
                                    index="3"
                                    slug="faqs"
                                >
                                    FAQ
                                </x-campaign::tab-button>
                            @endif
                        </x-slot>
                        <x-slot name="panels">
                            <x-campaign::tab-item index="0">
                                <div class="my-8 prose">
                                    {!! $campaign->renderedContent !!}
                                </div>
                                @auth
                                    <a
                                        href="{{ route('campaigns.content.story.edit', ['campaign' => $campaign]) }}"
                                        class="inline-flex items-center gap-2 text-sm text-gray-700 underline"
                                    >
                                        {{ __('Edit Story') }}<x-icons.pencil class="w-4 h-4 stroke-current" />
                                    </a>
                                @endauth
                            </x-campaign::tab-item>
                            @if ($faqs->count())
                                <x-campaign::tab-item index="3">
                                    <div class="my-8 prose">
                                        <x-public::faqs :$faqs />
                                    </div>
                                </x-campaign::tab-item>
                            @endif
                        </x-slot>
                    </x-campaign::tabs>
                </div>
            </div>

            <x-public::sidebar
                :donation_options="$donation_options"
                :$campaign
            />
        </div>
    </div>
</x-public::campaign-layout>
