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
            $table->string('deposit_amount')->after('hourly_rate');
            $table->string('gmail')->nullable();
            $table->string('gmail_api_password')->nullable();
            $table->string('zelle_email')->nullable();
            $table->string('zelle_phone')->nullable();
            $table->string('zelle_qr_code')->nullable(); // file path
            $table->string('referred_by_email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('artist_data', function (Blueprint $table) {
            $table->dropColumn([
                'deposit_amount',
                'gmail',
                'gmail_api_password',
                'zelle_email',
                'zelle_phone',
                'zelle_qr_code',
                'referred_by_email',
            ]);
        });
    }
};
