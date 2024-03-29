<?php

namespace Database\Seeders;

use App\Models\Equipment\CharMeasure;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CharMeasureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            'МБ',
            'шт',
            "''",
        ];

        foreach ($names as $name) {
            CharMeasure::create([
                'name' => $name,
            ]);
        }
    }
}
