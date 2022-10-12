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
        $urls = [
            'https://visasam.ru/emigration/canadausa/kak-poluchit-green-card-usa.html',
            'https://tonkosti.ru/%D0%92%D0%B8%D0%B7%D0%B0_%D0%B2_%D0%98%D1%81%D0%BF%D0%B0%D0%BD%D0%B8%D1%8E',
            'https://www.travel.ru/formalities/visa/schengen/',
            'https://visasam.ru',
            'https://www.travel.ru/formalities/visa/schengen/schengen_calculator.html',
            'https://viza-info.ru/covid/avstraliya-covid-travel',
        ];
        $selectors = [
            'h1',
            'title',
            'meta[name=\'description\']'
        ];
        return [
            'project_id' => Project::inRandomOrder()->first()->id,
            'url' => $urls[array_rand($urls)],
            'filters' => [
                'type' => 'html',
                'selector' => $selectors[array_rand($selectors)],
            ],
        ];
    }
}
