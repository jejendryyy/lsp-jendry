<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition()
    {
        $name = fake()->words(3, true);
        return [
            'category_id' => null,
            'name' => ucwords($name),
            'slug' => Str::slug($name) . '-' . fake()->unique()->numberBetween(100, 9999),
            'price' => 'Hubungi tim sales',
            'server_specs' => 'Contoh dummy',
            'short_description' => fake()->sentence(),
            'full_description' => '<p>' . fake()->paragraph() . '</p>',
            'image_url' => null,
            'sort_order' => 0,
        ];
    }
}
