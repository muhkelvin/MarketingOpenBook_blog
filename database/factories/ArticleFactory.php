<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence;

        return [
            'title'             => $title,
            'slug'              => Str::slug($title) . '-' . $this->faker->unique()->numberBetween(1, 10000),
            'body'              => $this->faker->paragraphs(5, true),
            'excerpt'           => $this->faker->text(200),
            'meta_title'        => $title,
            'image'=> $this->faker->imageUrl(),
            'meta_description'  => $this->faker->text(150),
            'published_at'      => $this->faker->optional()->dateTime,
        ];
    }
}
