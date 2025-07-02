<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hotel;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\Amenity;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create amenities first if they don't exist
        $this->createAmenities();

        // Create hotels with their room types and rooms
        $this->createHotelsWithRooms();
    }

    private function createAmenities(): void
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

        foreach ($amenities as $amenity) {
            Amenity::firstOrCreate(['name' => $amenity['name']], $amenity);
        }
    }

    private function createHotelsWithRooms(): void
    {
        $amenities = Amenity::all();

        // Create 5 luxury hotels
        Hotel::factory(5)->luxury()->create()->each(function ($hotel) use ($amenities) {
            $this->createRoomTypesAndRooms($hotel, $amenities, 'luxury');
        });

        // Create 10 regular hotels
        Hotel::factory(10)->create()->each(function ($hotel) use ($amenities) {
            $this->createRoomTypesAndRooms($hotel, $amenities, 'regular');
        });

        // Create 5 budget hotels
        Hotel::factory(5)->budget()->create()->each(function ($hotel) use ($amenities) {
            $this->createRoomTypesAndRooms($hotel, $amenities, 'budget');
        });
    }

    private function createRoomTypesAndRooms($hotel, $amenities, $category): void
    {
        $roomTypeCount = match ($category) {
            'luxury' => rand(4, 6),
            'regular' => rand(3, 5),
            'budget' => rand(2, 4),
        };

        // Create room types
        for ($i = 0; $i < $roomTypeCount; $i++) {
            $roomType = match ($category) {
                'luxury' => RoomType::factory()->luxury()->create(['hotel_id' => $hotel->id]),
                'budget' => RoomType::factory()->budget()->create(['hotel_id' => $hotel->id]),
                default => RoomType::factory()->create(['hotel_id' => $hotel->id]),
            };

            // Create rooms for each room type
            $roomCount = match ($category) {
                'luxury' => rand(8, 15),
                'regular' => rand(10, 20),
                'budget' => rand(15, 25),
            };

            $rooms = Room::factory($roomCount)->create([
                'hotel_id' => $hotel->id,
                'room_type_id' => $roomType->id,
            ]);

            // Attach amenities to rooms
            $rooms->each(function ($room) use ($amenities, $category) {
                $amenityCount = match ($category) {
                    'luxury' => rand(8, 12),
                    'regular' => rand(5, 8),
                    'budget' => rand(3, 6),
                };

                $selectedAmenities = $amenities->random(min($amenityCount, $amenities->count()));
                $room->amenities()->attach($selectedAmenities->pluck('id'));
            });
        }
    }
}