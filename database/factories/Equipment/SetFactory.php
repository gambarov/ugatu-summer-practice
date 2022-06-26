<?php

namespace Database\Factories\Equipment;

use App\Models\Employee;
use App\Models\Equipment\Set;
use Database\Factories\EmployeeFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipment\Set>
 */
class SetFactory extends Factory
{
    protected $model = Set::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $names = ['MOTA', 'JOTA', 'ZOTA', 'KOTA'];

        // mix names with 1-9 numbers to make it unique
        $mixed = array_merge(...array_map(function ($name) {
            return array_map(function ($number) use ($name) {
                return $name . '-' . $number;
            }, range(1, 9));
        }, $names));

        return [
            'name' => $this->faker->unique()->randomElement($mixed),
            'employee_id' => Employee::inRandomOrder()->firstOrCreate((new EmployeeFactory())->definition())->id,
        ];
    }
}
