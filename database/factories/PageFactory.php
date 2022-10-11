<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'project_id' => Project::inRandomOrder()->first()->id,
            'url' => $this->faker->url,
            'filters' => ['type' => 'html'],
        ];
    }
}
