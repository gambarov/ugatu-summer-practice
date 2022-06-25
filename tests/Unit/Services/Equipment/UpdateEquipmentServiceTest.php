<?php

namespace Tests\Unit\Services\Equipment;

use App\Models\Employee;
use App\Models\Equipment\Equipment;
use App\Models\Equipment\EquipmentType;
use App\Models\Equipment\Set;
use App\Models\Role;
use App\Services\Equipment\UpdateEquipmentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateEquipmentServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_updates_equipment()
    {
        EquipmentType::factory()->create();
        $equipment = Equipment::factory()->create();

        $data = [
            'id' => $equipment->id,
            'name' => 'UpdatedTestEquipment',
        ];

        $equipment = app(UpdateEquipmentService::class)->execute($data);

        $this->assertDatabaseHas('equipment', [
            'id' => $equipment->id,
            'name' => 'UpdatedTestEquipment',
        ]);

        $this->assertInstanceOf(Equipment::class, $equipment);
    }

    /**
     * @return void
     */
    public function test_updates_equipment_with_sets()
    {
        Role::factory()->create();
        Employee::factory()->create();

        EquipmentType::factory()->create();
        $equipment = Equipment::factory()->create();
        $set = Set::factory()->create();
        $set->equipment()->attach($equipment);
        $set2 = Set::factory()->create();

        $data = [
            'id' => $equipment->id,
            'name' => 'UpdatedTestEquipment',
            'sets' => [$set2->id],
        ];

        $equipment = app(UpdateEquipmentService::class)->execute($data);

        $this->assertInstanceOf(Equipment::class, $equipment);

        $this->assertDatabaseHas('equipment_set', [
            'equipment_id' => $equipment->id,
            'set_id' => $set2->id,
        ]);

        $this->assertDatabaseMissing('equipment_set', [
            'equipment_id' => $equipment->id,
            'set_id' => $set->id,
        ]);
    }
}
