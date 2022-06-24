<?php

namespace Database\Seeders;

use App\Models\Equipment\Equipment;
use App\Models\Equipment\Set;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Set::factory()->count(10)->create();

        foreach(Set::all() as $set) {
            $equipment = Equipment::inRandomOrder()->take(rand(3, 5))->pluck('id');
            $set->equipment()->attach($equipment);
        }
    }
}
