<?php

namespace Tests\Unit\Services\Set;

use App\Models\Employee;
use App\Models\Equipment\Equipment;
use App\Models\Equipment\EquipmentType;
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
            'name' => 'TestSet',
        ];

        $set = app(CreateSetService::class)->execute($data);

        $this->assertDatabaseHas('sets', [
            'id' => $set->id,
            'name' => 'TestSet',
        ]);

        $this->assertInstanceOf(Set::class, $set);
    }

    /**
     * @return void
     */
    public function test_creates_a_set_with_equipment()
    {
        EquipmentType::factory(2)->create();
        Equipment::factory(3)->create();

        $data = [
            'name' => 'TestSet',
            'equipment' => [1, 2, 3],
        ];

        $set = app(CreateSetService::class)->execute($data);

        $this->assertDatabaseHas('sets', [
            'id' => $set->id,
            'name' => 'TestSet',
        ]);

        $this->assertInstanceOf(Set::class, $set);

        $this->assertDatabaseHas('equipment_set', [
            'set_id' => $set->id,
            'equipment_id' => 1,
        ]);
    }
}
