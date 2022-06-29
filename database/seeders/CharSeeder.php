<?php

namespace Database\Seeders;

use App\Models\Equipment\Char;
use App\Models\Equipment\CharGroup;
use App\Models\Equipment\CharMeasure;
use App\Models\Equipment\Equipment;
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

        foreach (Equipment::all() as $equipment) {
            $chars = Char::inRandomOrder()->take(rand(1, 2))->pluck('id')->map(function ($id) {
                return [$id => ['value' => rand(1, 100)]];
            });
            $equipment->chars()->attach($chars[0]);
        }
    }
}
