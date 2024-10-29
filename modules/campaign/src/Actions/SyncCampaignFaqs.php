<?php

namespace Funds\Campaign\Actions;

use Funds\Campaign\Models\Campaign;

class SyncCampaignFaqs
{
    public function execute(Campaign $campaign, array $faqsData)
    {
        $faqIds = array_column($faqsData, 'id');

        $this->removeDeletedFaqs($campaign, $faqIds);

        foreach ($faqsData as $faq) {
            if (! $this->shouldUpdateFaq($faq)) {
                return;
            }

            if (! isset($faq['id']) || empty($faq['id'])) {
                $this->createNewFaq($campaign, $faq);

                continue;
            }

            $this->updateFaq($campaign, $faq);
        }
    }

    protected function removeDeletedFaqs(Campaign $campaign, array $faqIds)
    {
        $campaign->faqs()->whereNotIn('id', $faqIds)->delete();
    }

    protected function shouldUpdateFaq(array $faq)
    {
        return ! empty($faq['question']) && ! empty($faq['answer']);
    }

    protected function updateFaq(Campaign $campaign, array $data)
    {
        $campaign->faqs()->where('id', $data['id'])->update([
            'question' => $data['question'],
            'answer' => $data['answer'],
            'order' => $data['order'],
        ]);
    }

    protected function createNewFaq(Campaign $campaign, array $data)
    {
        $campaign->faqs()->create([
            'question' => $data['question'],
            'answer' => $data['answer'],
            'order' => $data['order'] ?? $campaign->faqs()->count() + 1,
        ]);
    }
}
