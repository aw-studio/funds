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
        Schema::create('donation_intents', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('email');
            $table->string('amount');
            $table->string('status');
            $table->foreignId('campaign_id')->constrained();
            $table->foreignId('donation_id')->nullable()->constrained();
            $table->boolean('pays_fees');

            $table->json('order_details')->nullable();

            $table->string('payment_intent')->nullable();
            $table->string('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_intents');
    }
};
