<?php

namespace Database\Factories;

use App\Constants\PromoTypes;
use App\Models\Promo;
use Illuminate\Database\Eloquent\Factories\Factory;

class PromoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $locales = main_locales();

        $names = [];
        $short_descriptions = [];
        $descriptions = [];
        $start_date = $this->faker->dateTimeBetween('now', '+2 months');
        $end_date = $this->faker->dateTimeBetween($start_date, '+2 months');
        $code = generate_valid_unique_code(
            Promo::class,
            "code",
            constant("valid_promo_characters"),
            constant("default_promo_length"),
            constant("valid_promo_regex")
        );

        foreach ($locales as $locale) {
            $names[$locale] = $this->faker->name();
            $short_descriptions[$locale] = $this->faker->text(50);
            $descriptions[$locale] = $this->faker->text(200);
        }

        return [
            'name' => $names,
            'short_description' => $short_descriptions,
            'description' => $descriptions,
            "percentage" => $this->faker->numberBetween(1, 50),
            "start_date" => $start_date,
            "end_date" => $end_date,
            "active" => $this->faker->numberBetween(0, 1),
            "type" => $this->faker->numberBetween(1, count(PromoTypes::getPromoTypes())),
            "code" => $code,
        ];
    }
}
