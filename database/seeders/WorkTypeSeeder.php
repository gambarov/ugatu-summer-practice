<?php

namespace Database\Seeders;

use App\Models\Equipment\WorkType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkTypeSeeder extends Seeder
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
            WorkType::create(['name' => $type]);
        }
    }
}
