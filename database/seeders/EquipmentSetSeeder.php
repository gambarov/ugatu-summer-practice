<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\EquipmentSet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EquipmentSetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EquipmentSet::factory()->count(10)->create();

        foreach(EquipmentSet::all() as $set) {
            $equipment = Equipment::inRandomOrder()->take(rand(3, 5))->pluck('id');
            $set->equipment()->attach($equipment);
        }
    }
}
