<?php

namespace Database\Seeders;

use App\Models\Audience;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AudienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Audience::factory()->count(10)->create();
    }
}
