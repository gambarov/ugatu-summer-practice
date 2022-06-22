<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Equipment;
use App\Models\EquipmentWorkStatus;
use App\Models\EquipmentWorkType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EquipmentWork>
 */
class EquipmentWorkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'equipment_id' => Equipment::inRandomOrder()->first()->id,
            'equipment_work_type_id' => EquipmentWorkType::inRandomOrder()->first()->id,
            'equipment_work_status_id' => EquipmentWorkStatus::inRandomOrder()->first()->id,
            'employee_id' => Employee::inRandomOrder()->first()->id
        ];
    }
}
