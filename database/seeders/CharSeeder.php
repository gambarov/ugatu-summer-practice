<?php

namespace Database\Seeders;

use App\Models\Equipment\Char;
use App\Models\Equipment\CharGroup;
use App\Models\Equipment\CharMeasure;
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
        $chars = [
            [
                'name' => 'Размер', 
                'char_measure_id' => CharMeasure::where('name', 'МБ')->first()->id, 
                'char_group_id' => CharGroup::where('name', 'Основная информация')->first()->id 
            ],
            [
                'name' => 'Диагональ', 
                'char_measure_id' => CharMeasure::where('name', "''")->first()->id, 
                'char_group_id' => CharGroup::where('name', 'Основная информация')->first()->id 
            ],
            [
                'name' => 'Кол-во', 
                'char_measure_id' => CharMeasure::where('name', 'шт')->first()->id, 
                'char_group_id' => CharGroup::where('name', 'Основная информация')->first()->id 
            ],
        ];

        foreach ($chars as $char) {
            Char::create($char);
        }
    }
}
