<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BlogItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $txt = $this->faker->realText(rand(1000, 4000));
        $is_free = rand(1, 3) > 1;
        $created_at = $this->faker->dateTimeBetween('-3 months', '-2 days');

        return [
            'title' => $this->faker->sentence(rand(3, 8), true),
            'brief_content' => $this->faker->text(rand(40, 100)),
            'raw_content' => $txt,
            'html_content' => $txt,
            'is_free' => $is_free,
            'is_published' => rand(1, 7) > 1,
            'external_url' => (!$is_free) ? 'https://www.patreon.com/' : null,
            'duration' => (!$is_free) ? rand(1, 100) : 0,
            'created_at' => $created_at,
            'updated_at' => $created_at,
        ];
    }
}
