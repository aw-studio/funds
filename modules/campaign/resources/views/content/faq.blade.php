<x-campaign::content-layout :$campaign>

    <x-section-headline
        value="FAQs"
        class="mb-8"
    />

    <form
        action="{{ route('campaigns.content.faqs.update', $campaign) }}"
        method="POST"
        x-cloak
        x-data
    >
        @csrf
        <div
            class="min-h-60"
            x-data="{
                faqs: @js($faqs),
                addFaq() {
                    this.faqs.push({
                        id: undefined,
                        order: this.faqs.length + 1,
                        question: '',
                        answer: '',
                    });
                },
                moveUp(faq) {
                    const index = this.faqs.indexOf(faq);
                    if (index > 0) {
                        [this.faqs[index], this.faqs[index - 1]] = [this.faqs[index - 1], this.faqs[index]];

                        this.faqs[index].order = index + 1;
                        this.faqs[index - 1].order = index;
                    }
                },
                moveDown(faq) {
                    const index = this.faqs.indexOf(faq);
                    if (index < this.faqs.length - 1) {
                        [this.faqs[index], this.faqs[index + 1]] = [this.faqs[index + 1], this.faqs[index]];

                        this.faqs[index].order = index + 1;
                        this.faqs[index + 1].order = index + 2;
                    }
                },
                deleteFaq(faq) {
                    const index = this.faqs.indexOf(faq);
                    this.faqs.splice(index, 1);
                },

            }"
        >
            <template x-for="(faq, index) in faqs">
                <div class="bg-gray-50 p-4 mb-4 rounded-lg flex gap-2">
                    <div class=" w-full">
                        <input
                            type="hidden"
                            x-bind:name="'faqs[' + index + '][id]'"
                            x-model="faq.id"
                        />
                        <x-input
                            label="{{ __('Question') }}"
                            placeholder="{{ __('Type your question here') }}"
                            class="w-full"
                            x-bind:name="'faqs[' + index + '][question]'"
                            x-model="faq.question"
                            errorKey="'faqs.' + index + '.question'"
                        />
                        <x-input-label class="mt-4">
                            {{ __('Answer') }}
                        </x-input-label>
                        <textarea
                            x-model="faq.answer"
                            x-bind:name="'faqs[' + index + '][answer]'"
                            @class(['mt-1 w-full rounded-md border-gray-200 sm:text-s'])
                        ></textarea>
                        <input
                            type="hidden"
                            x-bind:name="'faqs[' + index + '][order]'"
                            x-model="faq.order"
                        />
                    </div>
                    <div class="shrink-0 flex flex-col">
                        <button
                            type="button"
                            class="p-4"
                            x-on:click="moveUp(faq)"
                        >
                            <x-icons.arrow-up />
                        </button>
                        <button
                            type="button"
                            class="p-4"
                            x-on:click="moveDown(faq)"
                        >
                            <x-icons.arrow-down /></button>
                        <button
                            type="button"
                            class="p-4"
                            x-on:click="deleteFaq(faq)"
                        >

                            <x-icons.trash />
                        </button>
                    </div>
                </div>
            </template>
            <x-button
                x-on:click="addFaq()"
                type="button"
                outlined
                class="bg-transparent text-orange-500 border-transparent"
            >
                <x-icons.plus />
                {{ __('Add FAQ') }}
            </x-button>
        </div>
        <div class="border-t border-gray-200 mt-8 py-8 flex justify-end gap-4">
            <x-button
                outlined
                :href="$campaign->publicRoute()"
                target="_blank"
            >
                {{ __('View Campaign') }}
            </x-button>
            <x-button type="submit">
                {{ __('Save') }}
            </x-button>
        </div>
    </form>
</x-campaign::content-layout>
