<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Equipment\Equipment;
use App\Models\Note;
use Database\Factories\Equipment\EquipmentFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class NoteFactory extends Factory
{
    protected $model = Note::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'text' => $this->faker->text(),
            'equipment_id' => Equipment::inRandomOrder()->firstOrCreate((new EquipmentFactory())->definition())->id,
            'employee_id' => Employee::inRandomOrder()->firstOrCreate((new EmployeeFactory())->definition())->id,
        ];
    }
}
