<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true), 
            'price' => fake()->numberBetween(10000, 5000000),
            'stock' => fake()->numberBetween(1, 100),
            'image' => 'default.png', 
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
        ];
    }
}
