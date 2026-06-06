<?php

namespace Database\Factories;

use App\Models\Place;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'review_id' => $this->faker->unique()->numberBetween(1, 999999),
            'user_id' => User::factory(),
            'place_id' => Place::factory(),
            'rating_wifi' => $this->faker->numberBetween(1, 5),
            'rating_comfort' => $this->faker->numberBetween(1, 5),
            'rating_socket' => $this->faker->numberBetween(1, 5),
            'rating_overall' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->sentence(),
            'is_verified' => false,
        ];
    }

    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_verified' => true,
        ]);
    }
}
