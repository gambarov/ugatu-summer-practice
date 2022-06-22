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
        $this->call(AudienceTypeSeeder::class);
        $this->call(AudienceSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(EmployeeSeeder::class);
        $this->call(EquipmentTypeSeeder::class);
        $this->call(EquipmentSeeder::class);
        $this->call(EquipmentSetSeeder::class);
        $this->call(EquipmentCharGroupSeeder::class);
        $this->call(EquipmentCharMeasureSeeder::class);
        $this->call(EquipmentCharSeeder::class);
        $this->call(EquipmentWorkTypeSeeder::class);
        $this->call(EquipmentWorkStatusSeeder::class);
        $this->call(EquipmentWorkSeeder::class);
    }
}
