<?php

namespace Database\Seeders;

use App\Models\EquipmentCharGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EquipmentCharGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            'Классификация',
            'Габариты',
            'Дополнительная информация',
        ];

        foreach ($names as $name) {
            EquipmentCharGroup::create([
                'name' => $name,
            ]);
        }
    }
}
