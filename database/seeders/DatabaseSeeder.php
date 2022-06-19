<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AudienceSeeder::class);
        $this->call(EmployeeSeeder::class);
        $this->call(EquipmentTypeSeeder::class);
        $this->call(EquipmentSeeder::class);
        $this->call(EquipmentSetSeeder::class);
        $this->call(EquipmentCharSeeder::class);
    }
}
