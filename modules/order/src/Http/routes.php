<?php

use Funds\Order\Http\Controllers\OrderShippingAddressController;
use Illuminate\Support\Facades\Route;

Route::app(function () {
    Route::singleton('orders.shipping-address', OrderShippingAddressController::class)
        ->only(['edit', 'update']);

});
