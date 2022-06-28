<?php

namespace Database\Factories\Equipment;

use App\Models\Equipment\Audience;
use App\Models\Equipment\Equipment;
use App\Models\Equipment\Placement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipment\Placement>
 */
class PlacementFactory extends Factory
{
    protected $model = Placement::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'equipment_id' => Equipment::inRandomOrder()->firstOrCreate((new EquipmentFactory())->definition())->id,
            'audience_id' => Audience::inRandomOrder()->firstOrCreate((new AudienceFactory())->definition())->id,
        ];
    }
}
