<?php

namespace Database\Seeders;

use App\Models\EquipmentWorkStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EquipmentWorkStatusSeeder extends Seeder
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
            EquipmentWorkStatus::create(['name' => $status]);
        }
    }
}
