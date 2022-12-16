<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $locales = main_locales();

        $titles = [];
        $short_descriptions = [];
        $descriptions = [];

        foreach ($locales as $locale) {
            $titles[$locale] = $this->faker->name();
            $short_descriptions[$locale] = $this->faker->text(50);
            $descriptions[$locale] = $this->faker->text(200);
        }
        return [
            'title' => $titles,
            'short_description' => $short_descriptions,
            'description' => $descriptions,
            "active" => $this->faker->numberBetween(0,1),
        ];
    }
}
