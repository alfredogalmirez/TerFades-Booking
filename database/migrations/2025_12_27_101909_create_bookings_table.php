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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('service_id')->constrained()->cascadeOnDelete();

            // Guest booking details
            $table->string('customer_name');
            $table->string('phone', 20);
            $table->dateTime('scheduled_at'); // appointment date + time

            $table->string('status')->default('pending'); // pending/confirmed/done/cancelled
            $table->text('notes')->nullable();

            $table->timestamps();

            // Prevent double booking for same exact time slot
            $table->unique(['scheduled_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
