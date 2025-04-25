<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        $gender = $this->faker->randomElement(['male', 'female']);
        $firstName = $this->faker->firstName($gender);
        $lastName = $this->faker->lastName();
        
        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'username' => $this->faker->unique()->userName(),
            'gender' => $gender,
            'name' => "$firstName $lastName", // Full name
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'phone_number' => $this->faker->phoneNumber(),
            'matrix_number' => 'M' . $this->faker->unique()->numberBetween(1000, 9999),
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function seller(): static
    {
        return $this->afterCreating(function (User $user) {
            $user->assignRole('seller');
        });
    }
}
