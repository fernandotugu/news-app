<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\NewsCategory;

class NewsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'uuid' => Str::uuid(),

            'title' => fake()->sentence(),
            'content' => fake()->paragraphs(3, true),

            'category_id' => NewsCategory::query()->inRandomOrder()->value('id')
                ?? NewsCategory::factory(),

            'published_at' => fake()->boolean(80)
                ? fake()->dateTimeBetween('-1 month', 'now')
                : null,

            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
