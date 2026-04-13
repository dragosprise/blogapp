<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'post' => fake()->paragraph(),
            // The app expects a filename stored under storage/app/public/uploads (served via /storage/uploads/*).
            'image' => fake()->randomElement(['poza.png', 'poza2.webp', 'poza3.png']),
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
        ];
    }

    public function withTags(): static
    {
        return $this->afterCreating(function (Post $post) {
            $post->tags()->attach(Tag::factory()->count(3)->create());
        });
    }
}
