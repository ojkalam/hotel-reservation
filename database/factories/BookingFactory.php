<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Booking::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $checkInDate = $this->faker->dateTimeBetween('now', '+1 month');
        // $checkOutDate = $this->faker->dateTimeBetween($checkInDate, '+1 week');
        // Ensure check-out is after check-in
        $checkOutDate = $this->faker->dateTimeBetween(
                $checkInDate->format('Y-m-d H:i:s'),
                (clone $checkInDate)->modify('+7 days')->format('Y-m-d H:i:s')
            );
        $bookingType = $this->faker->randomElement(['walk-in', 'online']);

        // For walk-in bookings, we might not have a user_id
        $userData =
            $bookingType === 'walk-in'
                ? [
                    'user_id' => null,
                    'guest_name' => $this->faker->name(),
                    'guest_phone' => $this->faker->phoneNumber(),
                ]
                : [
                    'user_id' => User::factory(),
                    'guest_name' => null,
                    'guest_phone' => null,
                ];

        $status = $this->faker->randomElement(['booked', 'cancelled', 'checked_in', 'completed']);
        return array_merge($userData, [
            'booking_type' => $bookingType,
            'check_in_date' => $checkInDate,
            'check_out_date' => $status == 'completed' ? $checkOutDate : null,
            'guest_count' => $this->faker->numberBetween(1, 4),
            'status' => $status,
        ]);
    }

    /**
     * Indicate that the booking is for a walk-in guest.
     */
    public function walkIn(): static
    {
        return $this->state(
            fn(array $attributes) => [
                'booking_type' => 'walk-in',
                'user_id' => null,
                'guest_name' => $this->faker->name(),
                'guest_phone' => $this->faker->phoneNumber(),
            ],
        );
    }

    /**
     * Indicate that the booking is online.
     */
    public function online(): static
    {
        return $this->state(
            fn(array $attributes) => [
                'booking_type' => 'online',
                'user_id' => User::factory(),
                'guest_name' => null,
                'guest_phone' => null,
            ],
        );
    }

    /**
     * Indicate that the booking is active.
     */
    public function active(): static
    {
        return $this->state(
            fn(array $attributes) => [
                'status' => 'booked',
                'check_in_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            ],
        );
    }

    /**
     * Indicate that the booking is completed.
     */
    public function completed(): static
    {
        return $this->state(
            fn(array $attributes) => [
                'status' => 'completed',
                'check_in_date' => $this->faker->dateTimeBetween('-1 month', '-1 week'),
                'check_out_date' => $this->faker->dateTimeBetween('-1 week', 'now'),
            ],
        );
    }

    /**
     * Indicate that the booking is cancelled.
     */
    public function cancelled(): static
    {
        return $this->state(
            fn(array $attributes) => [
                'status' => 'cancelled',
            ],
        );
    }

    /**
     * Indicate that the guest is checked in.
     */
    public function checkedIn(): static
    {
        return $this->state(
            fn(array $attributes) => [
                'status' => 'checked_in',
                'check_in_date' => $this->faker->dateTimeBetween('-3 days', 'now'),
                'check_out_date' => $this->faker->dateTimeBetween('now', '+1 week'),
            ],
        );
    }
}
