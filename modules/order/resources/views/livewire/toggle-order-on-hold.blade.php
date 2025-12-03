<?php

use Funds\Order\Enums\OrderShipmentStatus;

use function Livewire\Volt\computed;
use function Livewire\Volt\state;

state(['order']);

$toggle = function () {
    $this->order->update([
        'shipment_status' => $this->order->shipment_status === OrderShipmentStatus::OnHold ? OrderShipmentStatus::Pending : OrderShipmentStatus::OnHold,
    ]);
};

$show = computed(function () {
    // only show if the state is either on hold or pending
    return in_array($this->order->shipment_status, [OrderShipmentStatus::OnHold, OrderShipmentStatus::Pending, OrderShipmentStatus::Errored]);
});

$markAsShipped = function () {
    $this->order->update([
        'shipment_status' => OrderShipmentStatus::Shipped,
    ]);
};

?>

<div class="flex items-center gap-2">
    <x-order::order-shipment-status-badge :order="$order" />
    @if ($this->show)
        <x-dropdown align="right">
            <x-slot name="trigger">
                <x-button
                    round
                    class="w-10 h-10 !p-0 items-center justify-center"
                >
                    <x-icons.dots class="text-white" />
                </x-button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link wire:click.prevent="toggle">
                    {{ $order->shipment_status === OrderShipmentStatus::OnHold ? __('Continue shipping') : __('Pause shipping') }}
                </x-dropdown-link>
                <x-dropdown-link
                    wire:click.prevent="markAsShipped"
                    wire:confirm="{{ __('Are you sure you want to mark this order as shipped?') }}"
                >
                    {{ __('Mark as shipped') }}
                </x-dropdown-link>
            </x-slot>
        </x-dropdown>
    @endif
</div>
