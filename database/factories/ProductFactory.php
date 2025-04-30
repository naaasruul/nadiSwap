<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Category;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $category = Category::inRandomOrder()->first();

        // If no categories are seeded, throw a helpful error
        if (!$category) {
            throw new \Exception('No categories found. Please run CategorySeeder before seeding products.');
        }

        $userId = User::inRandomOrder()->value('id') ?? \App\Models\User::factory()->create()->id;

        return [
            'name' => $this->faker->unique()->words(rand(1, 3), true),
            'description' => $this->faker->paragraphs(rand(1, 3), true),
            'category_id' => $category->id,
            'price' => $this->faker->randomFloat(2, 1, 1000),
            'stock' => $this->faker->numberBetween(0, 500),
            'images' => json_encode(array_map(
                fn() => 'storage/random' . rand(1, 6) . '.webp',
                range(1, 3)
            )),
            'seller_id' => $userId,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    public function outOfStock(): static
    {
        return $this->state(fn(array $attributes) => ['stock' => 0]);
    }

    public function inCategory(string $categoryName): static
    {
        return $this->state(function (array $attributes) use ($categoryName) {
            $category = Category::where('name', $categoryName)->first();

            if (!$category) {
                throw new \Exception("Category '{$categoryName}' not found. Make sure it's seeded.");
            }

            return ['category_id' => $category->id];
        });
    }

    public function discounted(float $percentage): static
    {
        return $this->state(function (array $attributes) use ($percentage) {
            $discount = $attributes['price'] * ($percentage / 100);
            return ['price' => $attributes['price'] - $discount];
        });
    }
}
