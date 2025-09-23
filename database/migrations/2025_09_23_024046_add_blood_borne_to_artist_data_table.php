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
            $table->string('blood_borne')->nullable()->after('shop_percentage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('artist_data', function (Blueprint $table) {
            $table->dropColumn('blood_borne');
        });
    }
};
