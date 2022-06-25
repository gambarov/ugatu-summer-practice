<?php

namespace Database\Factories\Equipment;

use App\Models\Equipment\Audience;
use App\Models\Equipment\AudienceType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipment\Audience>
 */
class AudienceFactory extends Factory
{
    protected $model = Audience::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $buildings = [ 1, 2, 3, 4, 5, 6, 7, 8, 9 ];
        $numbers = [ 115, 116, 215, 217, 316, 319, 415, 420, 525, 105 ];
        $letters = [ '', '', '', '', '', '', 'а', 'б' ];

        return [
            'building' => $buildings[array_rand($buildings)],
            'number' => $numbers[array_rand($numbers)],
            'letter' => $letters[array_rand($letters)],
            'audience_type_id' => AudienceType::inRandomOrder()->first()->id,
        ];
    }
}
