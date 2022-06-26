<?php

namespace Database\Factories\Equipment;

use App\Models\Equipment\Equipment;
use App\Models\Equipment\EquipmentType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipment\Equipment>
 */
class EquipmentFactory extends Factory
{
    protected $model = Equipment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'inventory_id' => $this->faker->unique()->numberBetween(100000, 999999),
            'equipment_type_id' => EquipmentType::inRandomOrder()->firstOrCreate(['name' => $this->faker->word()])->id,
        ];
    }
}
