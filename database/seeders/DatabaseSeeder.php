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
        $this->call(SetSeeder::class);
        $this->call(CharGroupSeeder::class);
        $this->call(CharMeasureSeeder::class);
        $this->call(CharSeeder::class);
        $this->call(WorkTypeSeeder::class);
        $this->call(WorkStatusSeeder::class);
        $this->call(WorkSeeder::class);
    }
}
