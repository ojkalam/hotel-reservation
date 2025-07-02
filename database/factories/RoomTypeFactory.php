<?php

namespace Database\Factories;

use App\Models\RoomType;
use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RoomType>
 */
class RoomTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RoomType::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $roomTypes = [
            ['name' => 'Standard Single', 'occupancy' => 1, 'price_range' => [50, 100]],
            ['name' => 'Standard Double', 'occupancy' => 2, 'price_range' => [80, 150]],
            ['name' => 'Deluxe Room', 'occupancy' => 2, 'price_range' => [120, 200]],
            ['name' => 'Executive Suite', 'occupancy' => 3, 'price_range' => [200, 350]],
            ['name' => 'Presidential Suite', 'occupancy' => 4, 'price_range' => [400, 800]],
            ['name' => 'Family Room', 'occupancy' => 4, 'price_range' => [150, 250]],
            ['name' => 'Twin Room', 'occupancy' => 2, 'price_range' => [70, 130]],
            ['name' => 'King Room', 'occupancy' => 2, 'price_range' => [100, 180]],
        ];

        $roomType = $this->faker->randomElement($roomTypes);

        return [
            'hotel_id' => Hotel::factory(),
            'type_name' => $roomType['name'],
            'description' => $this->faker->paragraph(2),
            'max_occupancy' => $roomType['occupancy'],
            'price_per_night' => $this->faker->randomFloat(2, $roomType['price_range'][0], $roomType['price_range'][1]),
        ];
    }

    /**
     * Indicate that the room type is luxury.
     */
    public function luxury(): static
    {
        return $this->state(fn (array $attributes) => [
            'type_name' => $this->faker->randomElement(['Presidential Suite', 'Royal Suite', 'Penthouse']),
            'price_per_night' => $this->faker->randomFloat(2, 500, 1000),
            'max_occupancy' => $this->faker->numberBetween(2, 6),
        ]);
    }

    /**
     * Indicate that the room type is budget.
     */
    public function budget(): static
    {
        return $this->state(fn (array $attributes) => [
            'type_name' => $this->faker->randomElement(['Economy Single', 'Budget Double', 'Hostel Bed']),
            'price_per_night' => $this->faker->randomFloat(2, 25, 75),
            'max_occupancy' => $this->faker->numberBetween(1, 2),
        ]);
    }
}