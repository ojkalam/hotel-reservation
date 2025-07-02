<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\Hotel;
use App\Models\RoomType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Room::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $floor = $this->faker->numberBetween(1, 20);
        $roomNumber = $floor . str_pad($this->faker->numberBetween(1, 50), 2, '0', STR_PAD_LEFT);

        return [
            'hotel_id' => Hotel::factory(),
            'room_type_id' => RoomType::factory(),
            'room_number' => $roomNumber,
            'floor' => $floor,
            'is_available' => $this->faker->boolean(85), // 85% chance of being available
        ];
    }

    /**
     * Indicate that the room is available.
     */
    public function available(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_available' => true,
        ]);
    }

    /**
     * Indicate that the room is occupied.
     */
    public function occupied(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_available' => false,
        ]);
    }

    /**
     * Create a room for a specific hotel and room type.
     */
    public function forHotelAndType(Hotel $hotel, RoomType $roomType): static
    {
        return $this->state(fn (array $attributes) => [
            'hotel_id' => $hotel->id,
            'room_type_id' => $roomType->id,
        ]);
    }
}