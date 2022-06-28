<?php

namespace Tests\Feature\API\V1;

use App\Models\Employee;
use App\Models\Equipment\Audience;
use App\Models\Equipment\Equipment;
use App\Models\Equipment\Placement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PlacementControllerTest extends TestCase
{
    use RefreshDatabase;

    private $jsonPlacement = [
        'id',
        'equipment',
        'audience',
        'placed_at',
        'removed_at',
    ];

    private $jsonEquipmentPlacements = [
        'id',
        'audience',
        'placed_at',
        'removed_at',
    ];

    /**
     * @return void
     */
    public function test_gets_a_list_of_placements()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        Placement::factory(10)->create();

        $response = $this->get('/api/placements');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => ['*' => $this->jsonPlacement],
        ]);
        $response->assertJsonCount(10, 'data');
    }

    /**
     * @return void
     */
    public function test_gets_equipment_placements()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        $equipment = Equipment::factory()->create();
        $equipment->audiences()->saveMany(Audience::factory(10)->make());

        $response = $this->get('/api/placements/equipment/' . $equipment->id);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => ['*' => $this->jsonEquipmentPlacements],
        ]);
        $response->assertJsonCount(10, 'data');
    }

    /**
     * @return void
     */
    public function test_stores_a_placement()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        $equipment = Equipment::factory()->create();
        $audience = Audience::factory()->create();

        $response = $this->post('/api/placements', [
            'equipment_id' => $equipment->id,
            'audience_id' => $audience->id,
            'placed_at' => now()->toDateTimeString(),
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => $this->jsonPlacement,
        ]);
    }

    /**
     * @return void
     */
    public function test_stores_and_update_removed_at_date_current_placement_for_equipment()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        $equipment = Equipment::factory()->create();
        $audience = Audience::factory()->create();
        $placement = Placement::factory()->create([
            'equipment_id' => $equipment->id,
            'audience_id' => $audience->id,
        ]);

        // FIXME:
        $placement = $equipment->currentPlacement();

        $newAudience = Audience::factory()->create();
        $response = $this->post('/api/placements', [
            'equipment_id' => $equipment->id,
            'audience_id' => $newAudience->id,
            'placed_at' => now()->toDateTimeString(),
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => $this->jsonPlacement,
        ]);
        $this->assertDatabaseHas('placements', [
            'id' => $placement->id,
            'removed_at' => now()->toDateTimeString(),
        ]);
    }

    /**
     * @return void
     */
    public function test_shows_a_placement()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        $placement = Placement::factory()->create();

        $response = $this->get('/api/placements/' . $placement->id);

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['*' => $this->jsonPlacement]]);
    }

    /**
     * @return void
     */
    public function test_updates_a_placement()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        $equipment = Equipment::factory()->create();
        $placement = Placement::factory()->create([
            'equipment_id' => $equipment->id,
        ]);

        // FIXME:
        $placement = $equipment->currentPlacement();

        $newEquipment = Equipment::factory()->create();

        $response = $this->json('PUT', '/api/placements/' . $placement->id, [
            'equipment_id' => $newEquipment->id,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => $this->jsonPlacement]);

        $this->assertDatabaseHas('placements', [
            'id' => $placement->id,
            'equipment_id' => $newEquipment->id,
        ]);
    }

    /**
     * @return void
     */
    public function test_deletes_a_placement()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        $equipment = Equipment::factory()->create();
        $placement = Placement::factory()->create([
            'equipment_id' => $equipment->id,
        ]);

        // FIXME:
        $placement = $equipment->currentPlacement();

        $response = $this->delete('/api/placements/' . $placement->id);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('placements', [
            'id' => $placement->id,
        ]);
    }
}
