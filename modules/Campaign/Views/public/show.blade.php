<x-public::campaign-layout
    :$campaign
    :header="false"
>
    <x-public::pitch :$campaign />
    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
        <div class="col-span-1 md:col-span-8 ">
            <x-campaigns::tabs>
                <x-slot name="buttons">
                    <x-campaigns::tab-button
                        index="0"
                        aria-selected="true"
                    >Story</x-campaigns::tab-button>
                    @if ($faqs->count())
                        <x-campaigns::tab-button index="1">FAQ</x-campaigns::tab-button>
                    @endif
                </x-slot>
                <x-slot name="panels">
                    <x-campaigns::tab-item index="0">
                        <div class="prose my-8">
                            {!! $campaign->renderedContent !!}
                        </div>
                    </x-campaigns::tab-item>
                    @if ($faqs->count())
                        <x-campaigns::tab-item index="1">
                            <div class="my-8 prose">
                                <x-public::faqs :$faqs />
                            </div>
                        </x-campaigns::tab-item>
                    @endif
                </x-slot>
            </x-campaigns::tabs>
        </div>
        <x-public::sidebar
            :donation_options="$donation_options"
            :$campaign
        />
    </div>
</x-public::campaign-layout>
