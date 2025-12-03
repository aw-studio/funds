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
        Schema::table('rewards', function (Blueprint $table) {
            $table->boolean('show_image_in_overview')->default(true)->after('expected_delivery');
        });

        // Set existing rewards to show image in overview
        \Funds\Reward\Models\Reward::query()->update(['show_image_in_overview' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rewards', function (Blueprint $table) {
            $table->dropColumn('show_image_in_overview');
        });
    }
};
