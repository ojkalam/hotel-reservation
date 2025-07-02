<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'booking_id' => Booking::factory(),
            'payment_method' => $this->faker->randomElement(['credit_card', 'paypal', 'cash']),
            'amount' => $this->faker->randomFloat(2, 50, 1000),
            'payment_status' => $this->faker->randomElement(['pending', 'paid', 'failed']),
            'payment_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }

    /**
     * Indicate that the payment is paid.
     */
    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'payment_status' => 'paid',
            'payment_date' => $this->faker->dateTimeBetween('-1 week', 'now'),
        ]);
    }

    /**
     * Indicate that the payment is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'payment_status' => 'pending',
            'payment_date' => now(),
        ]);
    }

    /**
     * Indicate that the payment failed.
     */
    public function failed(): static
    {
        return $this->state(fn (array $attributes) => [
            'payment_status' => 'failed',
            'payment_date' => $this->faker->dateTimeBetween('-1 week', 'now'),
        ]);
    }

    /**
     * Set credit card as payment method.
     */
    public function creditCard(): static
    {
        return $this->state(fn (array $attributes) => [
            'payment_method' => 'credit_card',
        ]);
    }

    /**
     * Set PayPal as payment method.
     */
    public function paypal(): static
    {
        return $this->state(fn (array $attributes) => [
            'payment_method' => 'paypal',
        ]);
    }

    /**
     * Set cash as payment method.
     */
    public function cash(): static
    {
        return $this->state(fn (array $attributes) => [
            'payment_method' => 'cash',
        ]);
    }

    /**
     * Create a payment for a specific booking.
     */
    public function forBooking(Booking $booking): static
    {
        return $this->state(fn (array $attributes) => [
            'booking_id' => $booking->id,
        ]);
    }
}