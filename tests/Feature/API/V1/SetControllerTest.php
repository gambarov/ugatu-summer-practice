<?php

namespace Tests\Feature\API\V1;

use App\Models\Employee;
use App\Models\Equipment\Equipment;
use App\Models\Equipment\Set;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SetControllerTest extends TestCase
{
    use RefreshDatabase;
    
    private $jsonSet = [
        'id',
        'name',
        'employee' => [
            'id',
            'surname',
            'name',
            'patronymic',
            'email',
            'role' => [
                'id',
                'name',
            ],
        ],
    ];

    private $jsonSetWithEquipment = [
        'id',
        'name',
        'employee' => [
            'id',
            'surname',
            'name',
            'patronymic',
            'email',
            'role' => [
                'id',
                'name',
            ],
        ],
        'equipment'
    ];

    /**
     * @return void
     */
    public function test_gets_a_list_of_sets()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        Set::factory(10)->create();

        $response = $this->json('GET', '/api/sets');

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['*' => $this->jsonSetWithEquipment]]);
    }

    /**
     * @return void
     */
    public function test_stores_a_new_set()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        $response = $this->json('POST', '/api/sets', [
            'name' => 'Test Set',
            'employee_id' => Employee::factory()->create()->id
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure(['data' => $this->jsonSet]);
    }

    /**
     * @return void
     */
    public function test_stores_a_new_set_with_equipment() 
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        $response = $this->json('POST', '/api/sets', [
            'name' => 'Test Set',
            'employee_id' => Employee::factory()->create()->id,
            'equipment' => [
                Equipment::factory()->create()->id,
                Equipment::factory()->create()->id,
            ]
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure(['data' => $this->jsonSetWithEquipment]);
    }

    /**
     * @return void
     */
    public function test_shows_a_set_with_sets()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        $set = Set::factory()->create();

        $response = $this->json('GET', '/api/sets/' . $set->id);

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => $this->jsonSetWithEquipment]);
    }

    /**
     * @return void
     */
    public function test_updates_a_set()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        $set = Set::factory()->create();

        $employee = Employee::factory()->create();
        $response = $this->json('PUT', '/api/sets/' . $set->id, [
            'name' => 'Test Set',
            'employee_id' => $employee->id
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => $this->jsonSet]);

        $this->assertDatabaseHas('sets', [
            'id' => $set->id,
            'name' => 'Test Set',
            'employee_id' => $employee->id,
        ]);
    }

    /**
     * @return void
     */
    public function test_updates_a_set_with_equipment()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        $set = Set::factory()->create();

        $employee = Employee::factory()->create();
        $equipment = Equipment::factory()->create();
        $response = $this->json('PUT', '/api/sets/' . $set->id, [
            'name' => 'Test Set',
            'employee_id' => $employee->id,
            'equipment' => [
                $equipment->id,
            ]
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => $this->jsonSetWithEquipment]);

        $this->assertDatabaseHas('sets', [
            'id' => $set->id,
            'name' => 'Test Set',
            'employee_id' => $employee->id,
        ]);
        $this->assertDatabaseHas('equipment_set', [
            'set_id' => $set->id,
            'equipment_id' => $equipment->id,
        ]);
    }

    /**
     * @return void
     */
    public function test_deletes_a_set()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        $set = Set::factory()->create();

        $response = $this->json('DELETE', '/api/sets/' . $set->id);

        $response->assertStatus(200);
        
        $this->assertDatabaseMissing('audiences', [
            'id' => $set->id
        ]);
    }
}
