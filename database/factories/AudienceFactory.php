<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Audience>
 */
class AudienceFactory extends Factory
{
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
        ];
    }
}
