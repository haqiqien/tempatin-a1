<?php

namespace Database\Factories;

use App\Models\Partner;
use App\Models\Place;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Place>
 */
class PlaceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'place_id' => $this->faker->unique()->numberBetween(1, 999999),
            'partner_id' => Partner::factory(),
            'place_name' => $this->faker->company().' Workspace',
            'category' => $this->faker->randomElement(['cafe', 'coworking', 'restoran', 'perpustakaan', 'lainnya']),
            'address' => $this->faker->address(),
            'city' => $this->faker->randomElement(['Jakarta', 'Bandung', 'Yogyakarta', 'Surabaya']),
            'latitude' => $this->faker->latitude(-8, -6),
            'longitude' => $this->faker->longitude(106, 112),
            'price_range' => '10000-30000',
            'opening_hours' => '08:00-22:00',
            'description' => $this->faker->paragraph(),
            'noise_level' => $this->faker->randomElement(['tenang', 'sedang', 'ramai']),
            'status' => 'active',
            'data_completeness_score' => 80,
            'cover_photo_url' => null,
        ];
    }

    public function pendingReview(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending_review',
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactive',
        ]);
    }
}
