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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
              // Foreign keys
            $table->unsignedBigInteger('hotel_id');
            $table->unsignedBigInteger('room_type_id');
            // Room details
            $table->string('room_number', 10); // VARCHAR(10)
            $table->integer('floor'); // INT
            $table->boolean('is_available')->default(true); // BOOLEAN DEFAULT TRUE

            $table->timestamps();
            // Foreign key constraints
            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');
            $table->foreign('room_type_id')->references('id')->on('room_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
