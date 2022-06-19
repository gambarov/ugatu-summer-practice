<?php

namespace Database\Seeders;

use App\Models\EquipmentChar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EquipmentCharSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            'Модель',
            'Вес',
            'Габариты',
            'Производитель',
            'Страна производитель',
        ];

        foreach ($names as $name) {
            EquipmentChar::create([
                'name' => $name,
            ]);
        }
    }
}
