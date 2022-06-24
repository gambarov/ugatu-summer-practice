<?php

namespace Database\Seeders;

use App\Models\Equipment\Char;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CharSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            'Модель',
            'Вес',
            'Габариты',
            'Производитель',
            'Страна производитель',
        ];

        foreach ($names as $name) {
            Char::create([
                'name' => $name,
            ]);
        }
    }
}
