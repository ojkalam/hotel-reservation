<?php

namespace Database\Factories;

use App\Models\BookingRoom;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookingRoom>
 */
class BookingRoomFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BookingRoom::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'booking_id' => Booking::factory(),
            'room_id' => Room::factory(),
            'price' => $this->faker->randomFloat(2, 50, 500),
        ];
    }

    /**
     * Create a booking room for specific booking and room.
     */
    public function forBookingAndRoom(Booking $booking, Room $room): static
    {
        return $this->state(fn (array $attributes) => [
            'booking_id' => $booking->id,
            'room_id' => $room->id,
        ]);
    }

    /**
     * Set a luxury price range.
     */
    public function luxury(): static
    {
        return $this->state(fn (array $attributes) => [
            'price' => $this->faker->randomFloat(2, 300, 1000),
        ]);
    }

    /**
     * Set a budget price range.
     */
    public function budget(): static
    {
        return $this->state(fn (array $attributes) => [
            'price' => $this->faker->randomFloat(2, 25, 100),
        ]);
    }
}