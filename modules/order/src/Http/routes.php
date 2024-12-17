<?php

use Funds\Order\Http\Controllers\OrderController;
use Funds\Order\Http\Controllers\OrderShippingAddressController;
use Illuminate\Support\Facades\Route;

Route::app(function () {
    Route::resource('orders', OrderController::class)
        ->only(['create', 'store', 'edit', 'update']);
    Route::singleton('orders.shipping-address', OrderShippingAddressController::class)
        ->only(['edit', 'update']);

});
