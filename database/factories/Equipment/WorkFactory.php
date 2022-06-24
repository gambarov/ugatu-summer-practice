<?php

namespace Database\Factories\Equipment;

use App\Models\Employee;
use App\Models\Equipment\Equipment;
use App\Models\Equipment\Work;
use App\Models\Equipment\WorkStatus;
use App\Models\Equipment\WorkType;
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
            'equipment_id' => Equipment::inRandomOrder()->first()->id,
            'work_type_id' => WorkType::inRandomOrder()->first()->id,
            'work_status_id' => WorkStatus::inRandomOrder()->first()->id,
            'employee_id' => Employee::inRandomOrder()->first()->id
        ];
    }
}
