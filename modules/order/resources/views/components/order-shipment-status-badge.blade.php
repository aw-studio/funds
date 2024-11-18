<x-badge
    class="px-2 py-1 rounded-md text-xs"
    :variant="$order->shipment_status->variant()"
>
    {{ __($order->shipment_status->label()) }}
</x-badge>
