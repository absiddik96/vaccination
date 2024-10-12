<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Random\RandomException;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws RandomException
     */
    public function definition(): array
    {
        return [
            'name'              => fake()->name(),
            'nid'               => $this->generateUniqueNid(),
            'email'             => fake()->unique()->safeEmail(),
            'phone'             => fake()->unique()->phoneNumber(),
        ];
    }

    /**
     * @throws RandomException
     */
    private function generateUniqueNid(): string
    {
        do {
            $nid = random_int(1, 9) . str_pad(random_int(0, 999999999), 9, '0', STR_PAD_LEFT);
        } while (User::query()->where('nid', $nid)->exists());

        return $nid;
    }
}
