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
        Schema::table('quotes', function (Blueprint $table) {
            $table->string('when_get_tattooed')->nullable();
            $table->string('reference_image')->nullable();
            $table->string('budget')->nullable();
            $table->date('availability')->nullable();
            $table->text('front_back_view')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->dropColumn('when_get_tattooed');
            $table->dropColumn('reference_image');
            $table->dropColumn('budget');
            $table->dropColumn('availability');
            $table->dropColumn('front_back_view');
        });
    }
    
};
