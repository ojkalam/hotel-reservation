<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Hotel;
use App\Models\Amenity;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\Booking;
use App\Models\BookingRoom;
use App\Models\Payment;
use App\Models\Review;
use Database\Seeders\HotelSeeder;
use Database\Seeders\BookingSeeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $this->call(HotelSeeder::class);
        // $this->call(BookingSeeder::class);

        $users = User::factory(50)->create();

        // Create amenities (fixed set)
        $amenities = collect([
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
        ])->map(function ($amenity) {
            return Amenity::create($amenity);
        });

        // Create hotels
        $hotels = collect();
        // Create luxury hotels
        Hotel::factory(3)->luxury()->create()->each(function ($hotel) use (&$hotels) {
            $hotels->push($hotel);
        });

        // Create budget hotels
        Hotel::factory(5)->budget()->create()->each(function ($hotel) use (&$hotels) {
            $hotels->push($hotel);
        });

        //  // Create regular hotels
        // Hotel::factory(7)->create()->each(function ($hotel) use (&$hotels) {
        //     $hotels->push($hotel);
        // });

        // Create room types and rooms for each hotel
        $allRooms = collect();
        $hotels->each(function ($hotel) use ($amenities, &$allRooms) {
            // Create 3-5 room types per hotel
            $roomTypes = RoomType::factory(rand(3, 5))->create([
                'hotel_id' => $hotel->id
            ]);

            $roomTypes->each(function ($roomType) use ($hotel, $amenities, &$allRooms) {
                // Create 5-15 rooms per room type
                $rooms = Room::factory(rand(5, 15))->create([
                    'hotel_id' => $hotel->id,
                    'room_type_id' => $roomType->id
                ]);

                // Attach random amenities to rooms
                $rooms->each(function ($room) use ($amenities) {
                    $randomAmenities = $amenities->random(rand(3, 8));
                    $room->amenities()->attach($randomAmenities->pluck('id'));
                });

                $allRooms = $allRooms->merge($rooms);
            });
        });

        // Create bookings
        $bookings = collect();
        // Create online bookings
        Booking::factory(10)->online()->create()->each(function ($booking) use (&$bookings) {
            $bookings->push($booking);
        });
        
        // Create walk-in bookings
        Booking::factory(5)->walkIn()->create()->each(function ($booking) use (&$bookings) {
            $bookings->push($booking);
        });

        // Create booking rooms (link bookings to rooms)
        $bookings->each(function ($booking) use ($allRooms) {
            // Each booking can have 1-3 rooms
            $selectedRooms = $allRooms->random(rand(1, 3));
            
            $selectedRooms->each(function ($room) use ($booking) {
                BookingRoom::factory()->create([
                    'booking_id' => $booking->id,
                    'room_id' => $room->id,
                    'price' => $room->roomType->price_per_night * rand(1, 7) // 1-7 nights
                ]);
            });
        });

        // Create payments for bookings
        $bookings->each(function ($booking) {
            // 90% chance of having a payment
            if (rand(1, 100) <= 90) {
                $totalAmount = $booking->bookingRooms->sum('price');
                
                Payment::factory()->create([
                    'booking_id' => $booking->id,
                    'amount' => $totalAmount,
                    'payment_status' => $booking->status === 'cancelled' ? 'failed' : 'paid'
                ]);
            }
        });

         // Create reviews
        $completedBookings = $bookings->where('status', 'completed')->where('booking_type', 'online');
        $completedBookings->each(function ($booking) use ($hotels) {
            // 70% chance of leaving a review
            if (rand(1, 100) <= 70) {
                $hotel = $hotels->random();
                
                Review::factory()->create([
                    'user_id' => $booking->user_id,
                    'hotel_id' => $hotel->id
                ]);
            }
        });

        // Create additional reviews from users who haven't booked
        Review::factory(30)->create();

    }
}
