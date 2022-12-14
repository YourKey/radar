<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'user_id' => User::inRandomOrder()->first()->id,
            'settings' => [
                'update_range' => 7*24,
                'telegram_fail_notify' => true,
                'telegram_success_notify' => false
            ],
        ];
    }
}
