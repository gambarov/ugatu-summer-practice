<?php

namespace Database\Seeders;

use App\Models\Equipment\AudienceType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AudienceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'Дисплейный',
        ];

        foreach ($types as $type) {
            AudienceType::create([
                'name' => $type,
            ]);
        }
    }
}
