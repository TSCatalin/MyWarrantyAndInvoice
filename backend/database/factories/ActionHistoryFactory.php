<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ActionHistory>
 */
class ActionHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'type_action' => $this->faker->randomElement(['DELETE', 'EDIT', 'CREATE']),
            'info_action' => $this->faker->word(),
            'date_action' => $this->faker->dateTime(),
        ];
    }
}
