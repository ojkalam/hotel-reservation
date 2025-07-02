<?php

namespace Database\Factories;

use App\Models\Amenity;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Amenity>
 */
class AmenityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Amenity::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $amenities = [
            ['name' => 'WiFi', 'icon' => 'wifi'],
            ['name' => 'Air Conditioning', 'icon' => 'snowflake'],
            ['name' => 'Television', 'icon' => 'tv'],
            ['name' => 'Mini Bar', 'icon' => 'wine-glass'],
            ['name' => 'Room Service', 'icon' => 'concierge-bell'],
            ['name' => 'Balcony', 'icon' => 'door-open'],
            ['name' => 'Safe', 'icon' => 'lock'],
            ['name' => 'Hair Dryer', 'icon' => 'wind'],
            ['name' => 'Coffee Maker', 'icon' => 'coffee'],
            ['name' => 'Jacuzzi', 'icon' => 'bath'],
            ['name' => 'Ocean View', 'icon' => 'water'],
            ['name' => 'City View', 'icon' => 'building'],
            ['name' => 'Spa Access', 'icon' => 'spa'],
            ['name' => 'Gym Access', 'icon' => 'dumbbell'],
            ['name' => 'Pool Access', 'icon' => 'swimmer'],
        ];

        $amenity = $this->faker->randomElement($amenities);

        return [
            'name' => $amenity['name'],
            'icon' => $amenity['icon'],
        ];
    }
}