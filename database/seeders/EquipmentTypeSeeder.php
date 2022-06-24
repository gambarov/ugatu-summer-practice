<?php

namespace Database\Seeders;

use App\Models\Equipment\EquipmentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EquipmentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'ПО',
            'АО'
        ];

        foreach ($types as $type) {
            EquipmentType::create([
                'name' => $type,
            ]);
        }
    }
}
