<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'email' => $this->faker->unique()->email(),
            'password' => $this->faker->unique()->password(),
            'surname' => $this->faker->lastName(),
            'name' => $this->faker->firstName(),
            'patronymic' => $this->faker->lastName(),
            'role_id' => Role::inRandomOrder()->first()->id,
        ];
    }
}
