<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->nullable()->constrained();
            $table->foreignId('donation_id')
                ->comment('Donation is the source and paymentof the order')
                ->constrained();
            $table->json('shipping_address')->nullable();
            $table->string('shipment_status')->nullable();
            $table->foreignId('reward_id')->nullable();
            $table->foreignId('reward_variant_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
