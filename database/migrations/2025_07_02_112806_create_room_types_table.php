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
        Schema::create('room_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hotel_id'); // hotel_id INT
            $table->string('type_name', 100); // type_name VARCHAR(100)
            $table->text('description')->nullable(); // description TEXT
            $table->integer('max_occupancy'); // max_occupancy INT
            $table->decimal('price_per_night', 10, 2); // price_per_night DECIMAL(10,2)
            $table->timestamps();
            // Foreign key constraint
            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_types');
    }
};
