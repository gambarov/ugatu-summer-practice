<?php

namespace Database\Seeders;

use App\Models\Equipment\WorkStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = ['Выполняется', 'Выполнена'];

        foreach($statuses as $status) {
            WorkStatus::create(['name' => $status]);
        }
    }
}
