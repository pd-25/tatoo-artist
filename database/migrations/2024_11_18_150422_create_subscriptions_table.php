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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('subscription_plan')->nullable();
            $table->string('status')->nullable();
            $table->string('payment_option')->nullable();
            $table->string('zell_email')->nullable();
            $table->string('zell_phone')->nullable();
            $table->string('ach_bank_name')->nullable();
            $table->string('ach_type')->nullable();
            $table->string('ach_routing_number')->nullable();
            $table->string('ach_account_number')->nullable();
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
