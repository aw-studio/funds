<?php

namespace Funds\Order\Enums;

enum OrderShipmentStatus: string
{
    /**
     * No shipment has been created yet.
     */
    case Pending = 'pending';

    /**
     * The order is currently being processed for shipment.
     */
    case InProgress = 'in_progress';

    /**
     * The order has been shipped.
     */
    case Shipped = 'shipped';

    /**
     * An error occurred while processing the shipment.
     */
    case Errored = 'error';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::InProgress => 'In Progress',
            self::Shipped => 'Shipped',
            self::Errored => 'Error',
        };
    }

    public function variant(): string
    {
        return match ($this) {
            self::Pending => 'gray',
            self::InProgress => 'blue',
            self::Shipped => 'success',
            self::Errored => 'danger',
        };
    }
}
