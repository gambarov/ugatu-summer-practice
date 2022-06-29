<?php

namespace Tests\Feature\API\V1;

use App\Models\Employee;
use App\Models\Equipment\Char;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CharControllerTest extends TestCase
{
    use RefreshDatabase;

    private $jsonChar = [
        'id',
        'name',
        'char_group' => [
            'id',
            'name'
        ],
        'char_measure' => [
            'id',
            'name'
        ]
    ];

    /**
     * @return void
     */
    public function test_gets_a_list_of_chars()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        Char::factory(10)->create();

        $response = $this->getJson('api/chars');

        $response->assertStatus(200);

        $response->assertJsonStructure(['data' => ['*' => $this->jsonChar]]);
    }

    /**
     * @return void
     */
    public function test_shows_a_char()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        $char = Char::factory()->create();

        $response = $this->getJson('api/chars/' . $char->id);

        $response->assertStatus(200);

        $response->assertJsonStructure(['data' => $this->jsonChar]);
    }

    /**
     * @return void
     */
    public function test_stores_a_char()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        $char = Char::factory()->create();

        $response = $this->postJson('api/chars', [
            'name' => 'Test Char',
            'char_group_id' => $char->char_group_id,
            'char_measure_id' => $char->char_measure_id,
        ]);

        $response->assertStatus(201);

        $response->assertJsonStructure(['data' => $this->jsonChar]);
    }

    /**
     * @return void
     */
    public function test_updates_a_char()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        $char = Char::factory()->create();

        $response = $this->putJson('api/chars/' . $char->id, [
            'name' => 'Test Char',
            'char_group_id' => $char->char_group_id,
            'char_measure_id' => $char->char_measure_id,
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure(['data' => $this->jsonChar]);

        $this->assertDatabaseHas('chars', [
            'id' => $char->id,
            'name' => 'Test Char',
            'char_group_id' => $char->char_group_id,
            'char_measure_id' => $char->char_measure_id,
        ]);
    }

    /**
     * @return void
     */
    public function test_deletes_a_char()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        $char = Char::factory()->create();

        $response = $this->deleteJson('api/chars/' . $char->id);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('chars', [
            'id' => $char->id
        ]);
    }
}
