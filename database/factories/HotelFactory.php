<?php

namespace Database\Factories;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hotel>
 */
class HotelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Hotel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company() . ' Hotel',
            'description' => $this->faker->paragraph(3),
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'country' => $this->faker->country(),
            'zipcode' => $this->faker->postcode(),
            'rating' => $this->faker->randomFloat(1, 1.0, 5.0),
        ];
    }

    /**
     * Indicate that the hotel is luxury.
     */
    public function luxury(): static
    {
        return $this->state(fn (array $attributes) => [
            'rating' => $this->faker->randomFloat(1, 4.0, 5.0),
            'name' => $this->faker->company() . ' Luxury Resort',
        ]);
    }

    /**
     * Indicate that the hotel is budget.
     */
    public function budget(): static
    {
        return $this->state(fn (array $attributes) => [
            'rating' => $this->faker->randomFloat(1, 2.0, 3.5),
            'name' => $this->faker->company() . ' Budget Inn',
        ]);
    }
}