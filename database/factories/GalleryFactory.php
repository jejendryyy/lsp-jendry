<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GalleryFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => fake()->sentence(5),
            'project_tag' => 'Dokumentasi',
            'image_path' => null,
            'caption' => fake()->sentence(12),
            'sort_order' => 0,
        ];
    }
}
