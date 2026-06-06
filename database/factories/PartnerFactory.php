<?php

namespace Database\Factories;

use App\Models\Partner;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Partner>
 */
class PartnerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'partner_id' => $this->faker->unique()->numberBetween(1, 999999),
            'user_id' => User::factory()->partner(),
            'business_name' => $this->faker->company(),
            'contact_name' => $this->faker->name(),
            'contact_phone' => $this->faker->phoneNumber(),
            'status' => 'active',
            'subscription_expires_at' => null,
        ];
    }
}
