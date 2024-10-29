<?php

use Funds\Campaign\Actions\SyncCampaignFaqs;
use Funds\Campaign\Models\Campaign;
use Funds\Campaign\Models\Faq;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(RefreshDatabase::class);
uses(TestCase::class);

beforeEach(function () {
    $this->campaign = Campaign::factory()->create();
    $this->action = new SyncCampaignFaqs;
});

it('creates new FAQs when no ID is provided', function () {
    $faqsData = [
        ['question' => 'What is this?', 'answer' => 'This is a FAQ', 'order' => 1],
        ['question' => 'How does it work?', 'answer' => 'Like this', 'order' => 2],
    ];

    $this->action->execute($this->campaign, $faqsData);

    expect($this->campaign->faqs()->count())->toBe(2);
    expect($this->campaign->faqs()->pluck('question')->toArray())->toMatchArray([
        'What is this?',
        'How does it work?',
    ]);
});

it('updates existing FAQs when ID is provided', function () {
    $existingFaq = Faq::factory()->for($this->campaign)->create([
        'question' => 'What is this?',
        'answer' => 'This is a FAQ',
        'order' => 1,
    ]);

    $faqsData = [
        ['id' => $existingFaq->id, 'question' => 'What is this?', 'answer' => 'Updated answer', 'order' => 1],
    ];

    $this->action->execute($this->campaign, $faqsData);

    $existingFaq->refresh();
    expect($existingFaq->answer)->toBe('Updated answer');
});

it('deletes FAQs that are not present in the provided data', function () {
    $faq1 = Faq::factory()->for($this->campaign)->create(['question' => 'Old FAQ 1', 'answer' => 'Old answer 1']);
    $faq2 = Faq::factory()->for($this->campaign)->create(['question' => 'Old FAQ 2', 'answer' => 'Old answer 2']);

    $faqsData = [
        ['id' => $faq1->id, 'question' => 'Old FAQ 1', 'answer' => 'Updated answer 1', 'order' => 1],
        // faq2 should be deleted
    ];

    $this->action->execute($this->campaign, $faqsData);

    expect($this->campaign->faqs()->count())->toBe(1);
    expect($this->campaign->faqs()->first()->question)->toBe('Old FAQ 1');
    expect(Faq::find($faq2->id))->toBeNull();
});

it('does not create or update FAQs with empty questions or answers', function () {
    $faqsData = [
        ['question' => '', 'answer' => 'No question', 'order' => 1],
        ['question' => 'No answer', 'answer' => '', 'order' => 2],
    ];

    $this->action->execute($this->campaign, $faqsData);

    expect($this->campaign->faqs()->count())->toBe(0);
});

it('handles mixed create  update and delete operations', function () {
    $existingFaq = Faq::factory()->for($this->campaign)->create([
        'question' => 'Existing FAQ',
        'answer' => 'Old answer',
        'order' => 1,
    ]);

    $faqsData = [
        // Should create a new FAQ
        ['question' => 'New FAQ', 'answer' => 'This is a new FAQ', 'order' => 2],
        // Should update the existing FAQ
        ['id' => $existingFaq->id, 'question' => 'Existing FAQ', 'answer' => 'Updated answer', 'order' => 1],
    ];

    $this->action->execute($this->campaign, $faqsData);

    expect($this->campaign->faqs()->count())->toBe(2);
    expect($this->campaign->faqs()->find($existingFaq->id)->answer)->toBe('Updated answer');
    expect($this->campaign->faqs()->where('question', 'New FAQ')->exists())->toBeTrue();
});
