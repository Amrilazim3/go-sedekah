<?php

namespace Database\Factories;

use App\Models\Bank;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DonationRequest>
 */
class DonationRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'bank_id' => Bank::factory(),
            'title' => $this->faker->text(30),
            'detail' => $this->faker->paragraph(1),
            'currently_received' => 0,
            'target_amount' => rand(10, 100)
        ];
    }
}
