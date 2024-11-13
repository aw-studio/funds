<?php

namespace Funds\Reward\Database\Factories;

use Funds\Campaign\Models\Campaign;
use Funds\Reward\Models\Reward;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Funds\Rewards\Models\Reward>
 */
class RewardFactory extends Factory
{
    protected $model = Reward::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $item = fake()->randomElement(array_keys($this->items()));

        return [
            'name' => $item,
            'slug' => Str::slug($item),
            'description' => $this->items()[$item],
            'min_amount' => random_int(1, 50) * 100,
            'campaign_id' => Campaign::factory(),
        ];

    }

    public function items()
    {
        return [
            'Eco-friendly Tote Bag' => 'A stylish and reusable tote bag featuring the campaign logo.',
            'Custom Water Bottle' => 'A high-quality, stainless steel water bottle with a custom design related to the campaign.',
            'Limited Edition Poster' => 'A beautifully designed, limited edition poster exclusive to campaign supporters.',
            'Campaign T-shirt' => 'A comfortable and stylish t-shirt with unique artwork celebrating the campaign.',
            'Personalized Notebook' => 'A custom notebook with the supporters name and a motivational quote from the campaign.',
            'Exclusive Mug' => 'A ceramic mug featuring campaign artwork, perfect for coffee or tea lovers.',
            'Handcrafted Jewelry' => 'A piece of handmade jewelry, such as a bracelet or necklace, inspired by the campaigns theme.',
            'Art Print' => 'A high-quality art print created by a local artist in support of the campaign.',
            'Signed Book' => 'A book related to the campaigns cause, signed by the author or campaign leader.',
            'VIP Gift Box' => 'A curated box of premium goodies, including a mix of campaign merchandise and local artisan products.',
            'Personalized Thank You Card' => 'A heartfelt thank you card personally signed by the campaign team.',
            'Custom Phone Case' => 'A durable phone case featuring campaign artwork, available for various phone models.',
            'Digital Artwork Pack' => 'A collection of high-resolution digital artwork files, perfect for wallpapers and screensavers.',
            'Exclusive Podcast Episode' => 'Access to an exclusive podcast episode featuring behind-the-scenes stories and interviews.',
            'Virtual Coffee Chat' => 'A one-on-one virtual coffee chat with a member of the campaign team to discuss the campaign and its goals.',
            'Name in Credits' => 'Your name featured in the credits section of campaign-related videos, websites, or publications.',
            'Online Workshop Access' => 'Exclusive access to an online workshop or webinar hosted by campaign organizers.',
            'Personalized Video Message' => 'A personalized video message from the campaign leader, thanking you for your support.',
            'Campaign Sticker Pack' => 'A collection of campaign-themed stickers to decorate your laptop, water bottle, or other belongings.',
            'VIP Event Invitation' => 'Invitation to a VIP event, such as a launch party or campaign milestone celebration, with special perks and privileges.',
        ];
    }
}
