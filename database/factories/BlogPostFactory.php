<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BlogPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence(rand(3, 8), true);
        $created_at = $this->faker->dateTimeBetween('-3 months', '-2 days');

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'is_published' => 1,
            'created_at' => $created_at,
            'updated_at' => $created_at,
        ];
    }
}
