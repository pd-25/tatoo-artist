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
        Schema::create('time_tables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('sunday_from')->nullable();
            $table->string('sunday_to')->nullable();
            $table->string('monday_from')->nullable();
            $table->string('monday_to')->nullable();
            $table->string('tuesday_from')->nullable();
            $table->string('tuesday_to')->nullable();
            $table->string('wednesday_from')->nullable();
            $table->string('wednesday_to')->nullable();
            $table->string('thrusday_from')->nullable();
            $table->string('thrusday_to')->nullable();
            $table->string('friday_from')->nullable();
            $table->string('friday_to')->nullable();
            $table->string('saterday_from')->nullable();
            $table->string('saterday_to')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_tables');
    }
};
