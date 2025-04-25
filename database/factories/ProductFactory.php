<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['Electronics', 'Clothing', 'Home & Garden', 'Books', 'Toys', 'Sports', 'Beauty', 'Food'];

        // Try to get a random user ID from the users table
        $userId = \App\Models\User::inRandomOrder()->value('id');

        // If no users exist, create one using the factory
        if (!$userId) {
            $userId = \App\Models\User::factory()->create()->id;
        }

        return [
            'name' => $this->faker->unique()->words(rand(1, 3), true),
            'description' => $this->faker->paragraphs(rand(1, 3), true),
            'category' => Arr::random($categories),
            'price' => $this->faker->randomFloat(2, 1, 1000),
            'stock' => $this->faker->numberBetween(0, 500),
            'image' => 'storage/random' . rand(1, 6) . '.webp',
            'seller_id' => $userId,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    /**
     * Indicate that the product is out of stock
     */
    public function outOfStock(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'stock' => 0,
            ];
        });
    }

    /**
     * Indicate that the product has a specific category
     */
    public function inCategory(string $category): static
    {
        return $this->state(function (array $attributes) use ($category) {
            return [
                'category' => $category,
            ];
        });
    }

    /**
     * Indicate that the product has a discount price
     */
    public function discounted(float $percentage): static
    {
        return $this->state(function (array $attributes) use ($percentage) {
            $discount = $attributes['price'] * ($percentage / 100);
            return [
                'price' => $attributes['price'] - $discount,
            ];
        });
    }
}