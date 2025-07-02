<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\User;
use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Review::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $rating = $this->faker->numberBetween(1, 5);
        
        // Generate comment based on rating
        $comments = [
            1 => [
                'Terrible experience. Would not recommend.',
                'Very disappointing stay. Poor service and facilities.',
                'Worst hotel experience ever. Avoid at all costs.',
            ],
            2 => [
                'Below average. Many issues with the room and service.',
                'Not satisfied with the stay. Expected much better.',
                'Poor value for money. Several problems during stay.',
            ],
            3 => [
                'Average hotel. Nothing special but acceptable.',
                'Decent stay but could be improved in several areas.',
                'Fair experience. Met basic expectations.',
            ],
            4 => [
                'Good hotel with nice amenities. Would stay again.',
                'Pleasant stay with friendly staff and clean rooms.',
                'Great location and service. Minor issues but overall good.',
            ],
            5 => [
                'Excellent hotel! Outstanding service and beautiful rooms.',
                'Perfect stay! Everything exceeded expectations.',
                'Amazing experience. Highly recommend this hotel.',
                'Fantastic hotel with world-class amenities and service.',
            ],
        ];

        return [
            'user_id' => User::factory(),
            'hotel_id' => Hotel::factory(),
            'rating' => $rating,
            'comment' => $this->faker->optional(0.8)->randomElement($comments[$rating]),
        ];
    }

    /**
     * Indicate that the review is positive (4-5 stars).
     */
    public function positive(): static
    {
        $rating = $this->faker->numberBetween(4, 5);
        
        return $this->state(fn (array $attributes) => [
            'rating' => $rating,
            'comment' => $this->faker->randomElement([
                'Excellent hotel! Outstanding service and beautiful rooms.',
                'Perfect stay! Everything exceeded expectations.',
                'Amazing experience. Highly recommend this hotel.',
                'Great location and service. Would definitely return.',
                'Wonderful amenities and very helpful staff.',
            ]),
        ]);
    }

    /**
     * Indicate that the review is negative (1-2 stars).
     */
    public function negative(): static
    {
        $rating = $this->faker->numberBetween(1, 2);
        
        return $this->state(fn (array $attributes) => [
            'rating' => $rating,
            'comment' => $this->faker->randomElement([
                'Terrible experience. Would not recommend.',
                'Very disappointing stay. Poor service and facilities.',
                'Below average. Many issues with the room and service.',
                'Not satisfied with the stay. Expected much better.',
                'Poor value for money. Several problems during stay.',
            ]),
        ]);
    }

    /**
     * Indicate that the review has no comment.
     */
    public function noComment(): static
    {
        return $this->state(fn (array $attributes) => [
            'comment' => null,
        ]);
    }

    /**
     * Create a review for a specific user and hotel.
     */
    public function forUserAndHotel(User $user, Hotel $hotel): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $user->id,
            'hotel_id' => $hotel->id,
        ]);
    }
}