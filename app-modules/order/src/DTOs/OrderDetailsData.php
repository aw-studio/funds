<?php

namespace Funds\Order\DTOs;

readonly class OrderDetailsData
{
    public function __construct(
        public int $rewardId,
        public ?int $rewardVariantId,
        public ShippingAddressData $shippingAddress,
    ) {}

    public static function from(array $array)
    {
        return new self(
            rewardId: $array['reward_id'],
            rewardVariantId: $array['reward_variant_id'] ?? null,
            shippingAddress: ShippingAddressData::from($array['shipping_address'])
        );
    }

    public function toArray(): array
    {
        return [
            'reward_id' => $this->rewardId,
            'reward_variant_id' => $this->rewardVariantId,
            'shipping_address' => $this->shippingAddress->toArray(),
        ];
    }
}
