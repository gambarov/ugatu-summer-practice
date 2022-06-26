<?php

namespace Tests\Unit\Services\Equipment;

use App\Models\Equipment\Equipment;
use App\Models\Equipment\EquipmentType;
use App\Models\Equipment\Set;
use App\Services\Equipment\CreateEquipmentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateEquipmentServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_creates_equipment()
    {
        $type = EquipmentType::create(['name' => 'type']);

        $data = [
            'name' => 'TestEquipment',
            'equipment_type_id' => $type->id,
            'inventory_id' => '12345',
        ];

        $equipment = app(CreateEquipmentService::class)->execute($data);

        $this->assertDatabaseHas('equipment', [
            'id' => $equipment->id,
            'name' => 'TestEquipment',
            'equipment_type_id' => $type->id,
            'inventory_id' => '12345',
        ]);

        $this->assertInstanceOf(Equipment::class, $equipment);
    }

    /**
     * @return void
     */
    public function test_creates_equipment_with_sets()
    {
        $type = EquipmentType::create(['name' => 'type']);
        $set = Set::factory()->create();
        $set2 = Set::factory()->create();

        $data = [
            'name' => 'TestEquipment',
            'equipment_type_id' => $type->id,
            'inventory_id' => '12345',
            'sets' => [$set->id, $set2->id],
        ];

        $equipment = app(CreateEquipmentService::class)->execute($data);

        $this->assertInstanceOf(Equipment::class, $equipment);

        $this->assertDatabaseHas('equipment_set', [
            'equipment_id' => $equipment->id,
            'set_id' => $set->id,
        ]);
        $this->assertDatabaseHas('equipment_set', [
            'equipment_id' => $equipment->id,
            'set_id' => $set2->id,
        ]);
    }
}
