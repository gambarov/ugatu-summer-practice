<?php

namespace Database\Seeders;

use App\Models\Equipment\Equipment;
use App\Models\Equipment\EquipmentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Equipment::factory()->count(100)->create();

        foreach(Equipment::all() as $equipment) {
            $type = EquipmentType::inRandomOrder()->first();
            $equipment->update(['equipment_type_id' => $type->id]);
        }
    }
}
