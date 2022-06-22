<?php

namespace Database\Seeders;

use App\Models\EquipmentCharMeasure;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EquipmentCharMeasureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            'ГГц',
            'МГц',
            'мА*ч',
            'мм',
            'кг',
        ];

        foreach ($names as $name) {
            EquipmentCharMeasure::create([
                'name' => $name,
            ]);
        }
    }
}
