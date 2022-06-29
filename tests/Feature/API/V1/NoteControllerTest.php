<?php

namespace Tests\Feature\API\V1;

use App\Models\Employee;
use App\Models\Equipment\Equipment;
use App\Models\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class NoteControllerTest extends TestCase
{
    use RefreshDatabase;

    private $jsonNote = [
        'id',
        'text',
        'equipment',
        'employee',
    ];

    /**
     * @return void
     */
    public function test_gets_a_list_of_notes()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        Note::factory(10)->create();

        $response = $this->getJson('api/notes');

        $response->assertStatus(200);

        $response->assertJsonStructure(['data' => ['*' => $this->jsonNote]]);
    }

    /**
     * @return void
     */
    public function test_shows_a_note()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        $note = Note::factory()->create();

        $response = $this->getJson('api/notes/' . $note->id);

        $response->assertStatus(200);

        $response->assertJsonStructure(['data' => $this->jsonNote]);
    }

    /**
     * @return void
     */
    public function test_stores_a_note()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        $response = $this->postJson('api/notes', [
            'text' => 'Test note',
            'equipment_id' => Equipment::factory()->create()->id,
            'employee_id' => Employee::factory()->create()->id,
        ]);

        $response->assertStatus(201);

        $response->assertJsonStructure(['data' => $this->jsonNote]);
    }

    /**
     * @return void
     */
    public function test_updates_a_note()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        $note = Note::factory()->create();

        $response = $this->putJson('api/notes/' . $note->id, [
            'text' => 'Test note',
            'equipment_id' => Equipment::factory()->create()->id,
            'employee_id' => Employee::factory()->create()->id,
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure(['data' => $this->jsonNote]);
    }

    /**
     * @return void
     */
    public function test_deletes_a_note()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        $note = Note::factory()->create();

        $response = $this->deleteJson('api/notes/' . $note->id);

        $response->assertStatus(200);
    }
}
