<?php

namespace Database\Factories\Equipment;

use App\Models\Employee;
use App\Models\Equipment\Equipment;
use App\Models\Equipment\Work;
use App\Models\Equipment\WorkStatus;
use App\Models\Equipment\WorkType;
use Database\Factories\EmployeeFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipment\Work>
 */
class WorkFactory extends Factory
{
    protected $model = Work::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'equipment_id' => Equipment::inRandomOrder()->firstOrCreate((new EquipmentFactory())->definition())->id,
            'work_type_id' => WorkType::inRandomOrder()->firstOrCreate(['name' => $this->faker->word()])->id,
            'work_status_id' => WorkStatus::inRandomOrder()->firstOrCreate(['name' => $this->faker->word()])->id,
            'employee_id' => Employee::inRandomOrder()->firstOrCreate((new EmployeeFactory())->definition())->id
        ];
    }
}
