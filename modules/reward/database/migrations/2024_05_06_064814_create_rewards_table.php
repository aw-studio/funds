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
        Schema::create('rewards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('min_amount')->default(0)->comment('Amount in cents');
            $table->string('type')->default('default');
            $table->string('shipping_type')->nullable();
            $table->string('packaging_instructions')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rewards');
    }
};
