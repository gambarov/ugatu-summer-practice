<?php

namespace Tests\Feature\API\V1;

use App\Models\Employee;
use App\Models\Equipment\Audience;
use App\Models\Equipment\AudienceType;
use App\Models\Equipment\Equipment;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AudienceControllerTest extends TestCase
{
    use RefreshDatabase;

    private $jsonAudience = [
        'id',
        'building',
        'number',
        'letter',
        'audience_type' => [
            'id',
            'name'
        ]
    ];

    private $jsonAudienceWithEquipment = [
        'id',
        'building',
        'number',
        'letter',
        'audience_type' => [
            'id',
            'name'
        ],
        'equipment'
    ];

    /**
     * @return void
     */
    public function test_gets_a_list_of_audiences()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        Audience::factory(10)->create();

        $response = $this->json('GET', '/api/audiences');

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['*' => $this->jsonAudienceWithEquipment]]);
    }

    /**
     * @return void
     */
    public function test_stores_a_new_audience()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        $type = AudienceType::create(['name' => 'Test']);
        $response = $this->json('POST', '/api/audiences', [
            'building' => '1',
            'number' => '1',
            'letter' => 'а',
            'audience_type_id' => $type->id
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure(['data' => $this->jsonAudience]);
    }

    /**
     * @return void
     */
    public function test_stores_a_new_audience_with_equipment() 
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        $type = AudienceType::create(['name' => 'Test']);
        $equipment = Equipment::factory()->create();
        $response = $this->json('POST', '/api/audiences', [
            'building' => '1',
            'number' => '1',
            'letter' => 'а',
            'audience_type_id' => $type->id,
            'equipment' => [$equipment->id]
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure(['data' => $this->jsonAudienceWithEquipment]);
    }

    /**
     * @return void
     */
    public function test_shows_an_audience()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        $audience = Audience::factory()->create();
        $response = $this->json('GET', '/api/audiences/' . $audience->id);

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => $this->jsonAudienceWithEquipment]);
    }

    /**
     * @return void
     */
    public function test_updates_an_audience()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        $audience = Audience::factory()->create();
        $response = $this->json('PUT', '/api/audiences/' . $audience->id, [
            'building' => '1',
            'number' => '1',
            'letter' => 'а',
            'audience_type_id' => $audience->audience_type_id
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => $this->jsonAudience]);

        $this->assertDatabaseHas('audiences', [
            'id' => $audience->id,
            'building' => '1',
            'number' => '1',
            'letter' => 'а',
            'audience_type_id' => $audience->audience_type_id
        ]);
    }

    /**
     * @return void
     */
    public function test_updates_an_audience_with_equipment()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        $audience = Audience::factory()->create();
        $equipment = Equipment::factory()->create();
        $response = $this->json('PUT', '/api/audiences/' . $audience->id, [
            'building' => '1',
            'number' => '1',
            'letter' => 'а',
            'audience_type_id' => $audience->audience_type_id,
            'equipment' => [$equipment->id]
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => $this->jsonAudienceWithEquipment]);

        $this->assertDatabaseHas('audiences', [
            'id' => $audience->id,
            'building' => '1',
            'number' => '1',
            'letter' => 'а',
            'audience_type_id' => $audience->audience_type_id
        ]);
        $this->assertDatabaseHas('placements', [
            'audience_id' => $audience->id,
            'equipment_id' => $equipment->id
        ]);
    }

    /**
     * @return void
     */
    public function test_deletes_an_audience()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        $audience = Audience::factory()->create();
        $response = $this->json('DELETE', '/api/audiences/' . $audience->id);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('audiences', [
            'id' => $audience->id
        ]);
    }

    /**
     * @return void
     */
    public function test_only_admin_can_delete_an_audience()
    {
        $role = Role::create(['name' => 'Администратор']);
        Sanctum::actingAs(Employee::factory()->create(['role_id' => $role->id]), ['*']);

        $audience = Audience::factory()->create();
        $response = $this->json('DELETE', '/api/audiences/' . $audience->id);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('audiences', [
            'id' => $audience->id
        ]);
    }

    /**
     * @return void
     */
    public function test_user_cant_delete_an_audience()
    {
        $role = Role::create(['name' => 'Пользователь']);
        Sanctum::actingAs(Employee::factory()->create(['role_id' => $role->id]), ['*']);

        $audience = Audience::factory()->create();
        $response = $this->json('DELETE', '/api/audiences/' . $audience->id);

        $response->assertStatus(401);

        $this->assertDatabaseHas('audiences', [
            'id' => $audience->id
        ]);
    }
}
