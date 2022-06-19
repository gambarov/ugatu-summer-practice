<?php

namespace Database\Seeders;

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
    }
}
