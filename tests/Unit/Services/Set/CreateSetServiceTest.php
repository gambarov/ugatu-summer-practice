<?php

namespace Tests\Unit\Services\Set;

use App\Models\Equipment\Equipment;
use App\Models\Equipment\Set;
use App\Services\Set\CreateSetService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateSetServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_creates_a_set()
    {
        $data = [
            'inventory_id' => '12346',
            'name' => 'TestSet',
        ];

        $set = app(CreateSetService::class)->execute($data);

        $this->assertDatabaseHas('sets', [
            'id' => $set->id,
            'inventory_id' => '12346',
            'name' => 'TestSet',
        ]);

        $this->assertInstanceOf(Set::class, $set);
    }

    /**
     * @return void
     */
    public function test_creates_a_set_with_equipment()
    {
        $equipment = Equipment::factory()->create();

        $data = [
            'name' => 'TestSet',
            'inventory_id' => '12345',
            'equipment' => [$equipment->id],
        ];

        $set = app(CreateSetService::class)->execute($data);

        $this->assertDatabaseHas('sets', [
            'id' => $set->id,
            'name' => 'TestSet',
            'inventory_id' => '12345',
        ]);

        $this->assertInstanceOf(Set::class, $set);

        $this->assertDatabaseHas('equipment_set', [
            'set_id' => $set->id,
            'equipment_id' => $equipment->id,
        ]);
    }
}
