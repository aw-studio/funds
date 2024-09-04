<?php

namespace Funds\Order\DTOs;

readonly class ShippingAddressData
{
    public function __construct(
        public string $name,
        public string $address,
        public ?string $addressAddition,
        public string $postalCode,
        public string $city,
        public string $country,
    ) {}

    public static function from(array $array)
    {
        return new self(
            name: $array['name'],
            address: $array['address'],
            addressAddition: $array['address_addition'] ?? null,
            postalCode: $array['postal_code'],
            city: $array['city'],
            country: $array['country'],
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'address' => $this->address,
            'address_addition' => $this->addressAddition,
            'postal_code' => $this->postalCode,
            'city' => $this->city,
            'country' => $this->country,
        ];
    }
}
