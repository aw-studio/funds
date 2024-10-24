<?php
use function Livewire\Volt\{state, mount, computed};
state(['campaign', 'newFaqName', 'newFaqAnswer']);

$faqs = computed(function () {
    return $this->campaign->faqs;
});
$addFaq = function () {
    $validated = $this->validate([
        'newFaqName' => ['required', 'string', 'max:255'],
        'newFaqAnswer' => ['required', 'string', 'max:255'],
    ]);
    $this->campaign->faqs()->create([
        'question' => $this->newFaqName,
        'answer' => $this->newFaqAnswer,
    ]);
    $this->reset(['newFaqName', 'newFaqAnswer']);
};

$removeFaq = function ($id) {
    $this->campaign->faqs()->find($id)->delete();
};
?>
<div>
    @foreach ($this->faqs as $faq)
        <div class="mb-2 flex p-4 border border-gray-200 rounded-md justify-between">
            <div>
                <h2 class="font-bold">{{ $faq->question }}</h2>
                <p class="pl-4">{{ $faq->answer }}</p>
            </div>
            <div>
                <span
                    class="cursor-pointer"
                    wire:click="removeFaq({{ $faq->id }})"
                    wire:confirm="Are you sure you want to delete this FAQ?"
                >&times;</span>
            </div>
        </div>
    @endforeach

    <div class="my-4 flex flex-col">
        <x-input
            type="text"
            wire:model="newFaqName"
            placeholder="What is your question?"
        />
        <x-textarea
            type="text"
            wire:model="newFaqAnswer"
            placeholder="Give the answer."
        />
        <x-button
            wire:click="addFaq"
            class="mt-4 self-end"
        >
            {{ 'Add Answer' }}
        </x-button>

    </div>
</div>
