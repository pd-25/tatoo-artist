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
        Schema::table('artist_data', function (Blueprint $table) {
            $table->string('specialty2')->nullable()->after('specialty');
            $table->string('specialty3')->nullable()->after('specialty2');
            $table->string('specialty4')->nullable()->after('specialty3');
            $table->string('specialty5')->nullable()->after('specialty4');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('artist_data', function (Blueprint $table) {
            $table->dropColumn(['specialty2', 'specialty3', 'specialty4', 'specialty5']);
        });
    }
};
