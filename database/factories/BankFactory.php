<?php

namespace Database\Factories;

use App\Models\BankDetail;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bank>
 */
class BankFactory extends Factory
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
            'bank_detail_id' => BankDetail::factory(),
            'name_on_card' => $this->faker->name(),
            'ic_number' => $this->faker->numberBetween(pow(10, 11), pow(10,12) - 1),
            'account_number' => $this->faker->creditCardNumber()
        ];
    }
}
