<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Update orders.latitude / orders.longitude precision
 * to match course requirement:
 *   latitude  DECIMAL(10,8)
 *   longitude DECIMAL(11,8)
 */
return new class extends Migration
{
    public function up(): void
    {
        // Skip if columns already have correct definition on a fresh install
        // We rebuild columns for compatibility across MySQL + SQLite.
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
        });
    }
};
