<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

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
        $category_ids = Category::pluck('id')->toArray();
        
        foreach ($locales as $locale) {
            $names[$locale] = $this->faker->name();
            $short_descriptions[$locale] = $this->faker->text(50);
            $descriptions[$locale] = $this->faker->text(200);
        }
        return [
            "category_id" => $category_ids[array_rand($category_ids)],
            'name' => $names,
            'short_description' => $short_descriptions,
            'description' => $descriptions,
            "price" => $this->faker->numberBetween(200,2000),
            "stock" => $this->faker->numberBetween(100,1000),
            "active" => $this->faker->numberBetween(0,1),
        ];
    }
}
