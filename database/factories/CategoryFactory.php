<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $locales = main_locales();
        
        $names = [];

        foreach ($locales as $locale) {
            $names[$locale] = $this->faker->name();
        }
        return [
            'name' => $names,
            "active" => $this->faker->numberBetween(0,1),
        ];
    }
}
