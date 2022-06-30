<?php

namespace Tests\Feature\API\V1;

use App\Models\Employee;
use App\Models\Equipment\Char;
use App\Models\Equipment\Equipment;
use App\Models\Equipment\EquipmentType;
use App\Models\Equipment\Set;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class EquipmentControllerTest extends TestCase
{
    use RefreshDatabase;

    private $jsonEquipment = [
        'id',
        'name',
        'inventory_id',
        'equipment_type' => [
            'id',
            'name',
        ],
        'sets',
        'chars'
    ];

    /**
     * @return void
     */
    public function test_gets_a_list_of_equipment_with_sets()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        Equipment::factory(10)->create();

        $response = $this->json('GET', '/api/equipment');

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['*' => $this->jsonEquipment]]);
    }

    /**
     * @return void
     */
    public function test_stores_a_new_equipment()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        $response = $this->json('POST', '/api/equipment', [
            'name' => 'Test Equipment',
            'inventory_id' => 'TEST-EQUIPMENT',
            'equipment_type_id' => EquipmentType::create(['name' => 'type'])->id
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure(['data' => $this->jsonEquipment]);
    }

    /**
     * @return void
     */
    public function test_stores_a_new_equipment_with_sets()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        $set = Set::factory()->create();

        $response = $this->json('POST', '/api/equipment', [
            'name' => 'Test Equipment',
            'inventory_id' => 'TEST-EQUIPMENT',
            'equipment_type_id' => EquipmentType::create(['name' => 'type'])->id,
            'sets' => [$set->id]
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure(['data' => $this->jsonEquipment]);
    }

    /**
     * @return void
     */
    public function test_shows_an_equipment_with_sets()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        $equipment = Equipment::factory()->create();

        $response = $this->json('GET', '/api/equipment/' . $equipment->id);

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => $this->jsonEquipment]);
    }

    /**
     * @return void
     */
    public function test_updates_an_equipment()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        $equipment = Equipment::factory()->create();
        $type = EquipmentType::create(['name' => 'type']);

        $response = $this->json('PUT', '/api/equipment/' . $equipment->id, [
            'name' => 'Test Equipment',
            'inventory_id' => 'TEST-EQUIPMENT',
            'equipment_type_id' => $type->id
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => $this->jsonEquipment]);

        $this->assertDatabaseHas('equipment', [
            'id' => $equipment->id,
            'name' => 'Test Equipment',
            'inventory_id' => 'TEST-EQUIPMENT',
            'equipment_type_id' => $type->id
        ]);
    }

    /**
     * @return void
     */
    public function test_updates_an_equipment_with_sets()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        $equipment = Equipment::factory()->create();
        $type = EquipmentType::create(['name' => 'type']);
        $set = Set::factory()->create();

        $response = $this->json('PUT', '/api/equipment/' . $equipment->id, [
            'name' => 'Test Equipment',
            'inventory_id' => 'TEST-EQUIPMENT',
            'equipment_type_id' => $type->id,
            'sets' => [$set->id]
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => $this->jsonEquipment]);

        $this->assertDatabaseHas('equipment', [
            'id' => $equipment->id,
            'name' => 'Test Equipment',
            'inventory_id' => 'TEST-EQUIPMENT',
            'equipment_type_id' => $type->id
        ]);

        $this->assertDatabaseHas('equipment_set', [
            'equipment_id' => $equipment->id,
            'set_id' => $set->id
        ]);
    }

    /**
     * @return void
     */
    public function test_deletes_an_equipment()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        $equipment = Equipment::factory()->create();

        $response = $this->json('DELETE', '/api/equipment/' . $equipment->id);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('equipment', [
            'id' => $equipment->id
        ]);
    }

    /**
     * @return void
     */
    public function test_throws_validation_error_when_storing_equipment_with_wrong_sets_array()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        $response = $this->json('POST', '/api/equipment', [
            'name' => 'Test Equipment',
            'inventory_id' => 'TEST-EQUIPMENT',
            'equipment_type_id' => EquipmentType::create(['name' => 'type'])->id,
            'sets' => [-1, 'test']
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['error' => ['message', 'errors']]);
    }

    /**
     * @return void
     */
    public function test_stores_a_equipment_with_chars()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        $char = Char::factory()->create();

        $response = $this->json('POST', '/api/equipment', [
            'name' => 'Test Equipment',
            'inventory_id' => 'TEST-EQUIPMENT',
            'equipment_type_id' => EquipmentType::create(['name' => 'type'])->id,
            'chars' => [
                [$char->id => ['value' => 50]],
            ]
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure(['data' => $this->jsonEquipment]);

        $this->assertDatabaseHas('equipment_char', [
            'equipment_id' => $response->json('data.id'),
            'char_id' => $char->id,
            'value' => 50
        ]);
    }

    /**
     * @return void
     */
    public function test_updates_an_equipment_with_chars()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        $equipment = Equipment::factory()->create();
        $char = Char::factory()->create();

        $response = $this->json('PUT', '/api/equipment/' . $equipment->id, [
            'name' => 'Test Equipment',
            'inventory_id' => 'TEST-EQUIPMENT',
            'equipment_type_id' => EquipmentType::create(['name' => 'type'])->id,
            'chars' => [
                [$char->id => ['value' => 50]],
            ]
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => $this->jsonEquipment]);

        $this->assertDatabaseHas('equipment_char', [
            'equipment_id' => $equipment->id,
            'char_id' => $char->id,
            'value' => 50
        ]);
    }     
}
