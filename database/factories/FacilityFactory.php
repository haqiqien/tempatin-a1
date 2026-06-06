<?php

namespace Database\Factories;

use App\Models\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Facility>
 */
class FacilityFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->unique()->slug(2);

        return [
            'facility_id' => $this->faker->unique()->numberBetween(1, 999999),
            'facility_name' => $name,
            'icon_name' => 'wifi',
            'label' => str($name)->replace('-', ' ')->title()->toString(),
        ];
    }
}
