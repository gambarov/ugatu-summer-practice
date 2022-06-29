<?php

namespace Database\Factories\Equipment;

use App\Models\Equipment\Char;
use App\Models\Equipment\CharGroup;
use App\Models\Equipment\CharMeasure;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipment\Char>
 */
class CharFactory extends Factory
{
    protected $model = Char::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'char_group_id' => CharGroup::inRandomOrder()->firstOrCreate(['name' => $this->faker->word()])->id,
            'char_measure_id' => CharMeasure::inRandomOrder()->firstOrCreate(['name' => $this->faker->word()])->id,
        ];
    }
}
