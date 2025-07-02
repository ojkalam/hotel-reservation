<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Room;
use App\Models\Booking;
use App\Models\BookingRoom;
use App\Models\Payment;
use App\Models\Review;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we have users and rooms
        $users = User::all();
        $rooms = Room::all();

        if ($users->isEmpty()) {
            $users = User::factory(30)->create();
        }

        if ($rooms->isEmpty()) {
            $this->command->error('No rooms found. Please run HotelSeeder first.');
            return;
        }

        // Create various types of bookings
        $this->createOnlineBookings($users, $rooms);
        $this->createWalkInBookings($rooms);
        $this->createCompletedBookingsWithReviews($users, $rooms);
    }

    private function createOnlineBookings($users, $rooms): void
    {
        // Create 50 active online bookings
        Booking::factory(50)->online()->active()->create()->each(function ($booking) use ($rooms) {
            $this->attachRoomsToBooking($booking, $rooms);
            $this->createPaymentForBooking($booking);
        });

        // Create 20 checked-in bookings
        Booking::factory(20)->online()->checkedIn()->create()->each(function ($booking) use ($rooms) {
            $this->attachRoomsToBooking($booking, $rooms);
            $this->createPaymentForBooking($booking, 'paid');
        });

        // Create 10 cancelled bookings
        Booking::factory(10)->online()->cancelled()->create()->each(function ($booking) use ($rooms) {
            $this->attachRoomsToBooking($booking, $rooms);
            // Some cancelled bookings might have failed payments
            if (rand(1, 100) <= 60) {
                $this->createPaymentForBooking($booking, 'failed');
            }
        });
    }

    private function createWalkInBookings($rooms): void
    {
        // Create 15 walk-in bookings
        Booking::factory(15)->walkIn()->create()->each(function ($booking) use ($rooms) {
            $this->attachRoomsToBooking($booking, $rooms);
            $this->createPaymentForBooking($booking, 'paid'); // Walk-ins usually pay immediately
        });
    }

    private function createCompletedBookingsWithReviews($users, $rooms): void
    {
        // Create 40 completed bookings
        $completedBookings = Booking::factory(40)->completed()->create();
        
        $completedBookings->each(function ($booking) use ($rooms) {
            $this->attachRoomsToBooking($booking, $rooms);
            $this->createPaymentForBooking($booking, 'paid');
            
            // 70% chance of creating a review for completed bookings
            if (rand(1, 100) <= 70) {
                $this->createReviewForBooking($booking);
            }
        });
    }

    private function attachRoomsToBooking($booking, $rooms): void
    {
        // Each booking gets 1-3 rooms
        $numberOfRooms = rand(1, 3);
        $selectedRooms = $rooms->random($numberOfRooms);
        
        $selectedRooms->each(function ($room) use ($booking) {
            // Calculate price based on room type and random number of nights (1-7)
            $nights = rand(1, 7);
            $pricePerNight = $room->roomType->price_per_night ?? rand(50, 300);
            $totalPrice = $pricePerNight * $nights;

            BookingRoom::create([
                'booking_id' => $booking->id,
                'room_id' => $room->id,
                'price' => $totalPrice,
            ]);
        });
    }

    private function createPaymentForBooking($booking, $status = null): void
    {
        $totalAmount = $booking->bookingRooms->sum('price');
        
        if ($totalAmount > 0) {
            $paymentStatus = $status ?? match ($booking->status) {
                'cancelled' => rand(1, 100) <= 50 ? 'failed' : 'pending',
                'completed', 'checked_in' => 'paid',
                default => 'paid',
            };

            Payment::factory()->create([
                'booking_id' => $booking->id,
                'amount' => $totalAmount,
                'payment_status' => $paymentStatus,
                'payment_method' => $booking->booking_type === 'walk-in' ? 'cash' : 'credit_card',
            ]);
        }
    }

    private function createReviewForBooking($booking): void
    {
        // Get the hotel from the first room in the booking
        $firstRoom = $booking->bookingRooms->first()?->room;
        
        if ($firstRoom && $booking->user_id) {
            Review::factory()->create([
                'user_id' => $booking->user_id,
                'hotel_id' => $firstRoom->hotel_id,
            ]);
        }
    }
}