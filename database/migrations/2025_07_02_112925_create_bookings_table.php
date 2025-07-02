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
            // Foreign key to users (nullable for walk-in)
            $table->unsignedBigInteger('user_id')->nullable();

            // Guest info (for walk-ins)
            $table->string('guest_name', 100)->nullable();
            $table->string('guest_phone', 20)->nullable();

            // Booking type (enum)
            $table->enum('booking_type', ['walk-in', 'online'])->default('online');

            // Dates and guest count
            $table->datetime('check_in_date')->nullable();
            $table->datetime('check_out_date')->nullable();
            $table->integer('guest_count')->default(1);

            // Booking status
            $table->enum('status', ['booked', 'cancelled', 'checked_in', 'completed'])->default('booked');

            // Timestamp
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
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
