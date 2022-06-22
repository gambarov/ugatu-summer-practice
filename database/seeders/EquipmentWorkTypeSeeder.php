<?php

namespace Database\Seeders;

use App\Models\EquipmentWorkType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EquipmentWorkTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ['Очистка', 'Ремонт'];

        foreach($types as $type) {
            EquipmentWorkType::create(['name' => $type]);
        }
    }
}
