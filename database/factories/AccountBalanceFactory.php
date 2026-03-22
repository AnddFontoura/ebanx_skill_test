<?php

namespace Database\Factories;

use App\Models\Accounts;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AccountBalance>
 */
class AccountBalanceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'account_id' => Accounts::factory()->create()->id,
            'type' => fake()->randomElement([1, 2]),
            'amount' => fake()->numberBetween(100, 1000),
        ];
    }
}
