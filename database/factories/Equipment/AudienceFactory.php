<?php

namespace Database\Factories\Equipment;

use App\Models\Equipment\Audience;
use App\Models\Equipment\AudienceType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipment\Audience>
 */
class AudienceFactory extends Factory
{
    protected $model = Audience::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'building' => $this->faker->numberBetween(1, 9),
            'number' => $this->faker->unique()->numberBetween(100, 530),
            'letter' => $this->faker->randomElement(['', 'а', 'б']),
            'audience_type_id' => AudienceType::inRandomOrder()->firstOrCreate(['name' => $this->faker->word()])->id,
        ];
    }
}
