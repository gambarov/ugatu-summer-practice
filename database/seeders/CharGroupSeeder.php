<?php

namespace Database\Seeders;

use App\Models\Equipment\CharGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CharGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            'Основная информация',
            'Классификация',
            'Габариты',
            'Дополнительная информация',
        ];

        foreach ($names as $name) {
            CharGroup::create([
                'name' => $name,
            ]);
        }
    }
}
