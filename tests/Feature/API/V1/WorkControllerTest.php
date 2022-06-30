<?php

namespace Tests\Feature\API\V1;

use App\Models\Employee;
use App\Models\Equipment\Equipment;
use App\Models\Equipment\Set;
use App\Models\Equipment\Work;
use App\Models\Equipment\WorkStatus;
use App\Models\Equipment\WorkType;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class WorkControllerTest extends TestCase
{
    use RefreshDatabase;

    private $jsonWorkable =  [
        'id',
        'workable',
        'work_type',
        'work_status',
        'started_at',
        'ended_at',
        'employee',
    ];

    /**
     * @return void
     */
    public function test_gets_a_list_of_works()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        Work::factory(10)->create();

        $response = $this->getJson('/api/works');

        $response->assertStatus(200);
        $response->assertJsonCount(10, 'data');
        $response->assertJsonStructure([
            'data' => ['*' => $this->jsonWorkable],
        ]);
    }

    /**
     * @return void
     */
    public function test_stores_a_equipment_work()
    {
        $employee = Employee::factory()->create();
        Sanctum::actingAs($employee, ['*']);

        $type = WorkType::create(['name' => 'Ремонт']);
        $status = WorkStatus::create(['name' => 'Выполняется']);

        $equipment = Equipment::factory()->create();

        $response = $this->postJson('/api/works', [
            'workable_id' => $equipment->id,
            'workable_type' => 'equipment',
            'work_type_id' => $type->id,
            'work_status_id' => $status->id,
            'employee_id' => $employee->id,
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => $this->jsonWorkable,
        ]);
    }

    /**
     * @return void
     */
    public function test_shows_a_work()
    {
        $employee = Employee::factory()->create();
        Sanctum::actingAs($employee, ['*']);

        $work = Work::factory()->create();

        $response = $this->getJson('/api/works/' . $work->id);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => $this->jsonWorkable,
        ]);
    }

    /**
     * @return void
     */
    public function test_updates_a_equipment_work_to_set_work()
    {
        $employee = Employee::factory()->create();
        Sanctum::actingAs($employee, ['*']);

        $type = WorkType::create(['name' => 'Ремонт']);
        $status = WorkStatus::create(['name' => 'Выполняется']);
        $set = Set::factory()->create();

        $work = Work::factory()->create();

        $ended_at = Carbon::now()->toDateTimeString();

        $response = $this->putJson('/api/works/' . $work->id, [
            'workable_id' => $set->id,
            'workable_type' => 'set',
            'work_type_id' => $type->id,
            'work_status_id' => $status->id,
            'employee_id' => $employee->id,
            'ended_at' => $ended_at,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => $this->jsonWorkable,
        ]);

        $this->assertDatabaseHas('works', [
            'id' => $work->id,
            'workable_id' => $set->id,
            'workable_type' => 'App\Models\Equipment\Set',
            'work_type_id' => $type->id,
            'work_status_id' => $status->id,
            'employee_id' => $employee->id,
            'ended_at' => $ended_at,
        ]);
    }

    /**
     * @return void
     */
    public function test_deletes_a_work()
    {
        $employee = Employee::factory()->create();
        Sanctum::actingAs($employee, ['*']);

        $work = Work::factory()->create();

        $response = $this->deleteJson('/api/works/' . $work->id);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('works', [
            'id' => $work->id,
        ]);
    }    

    /**
     * @return void
     */
    public function test_gets_workable_works()
    {
        $employee = Employee::factory()->create();
        Sanctum::actingAs($employee, ['*']);

        $equipment = Equipment::factory()->create();
        Work::factory()->create([
            'workable_id' => $equipment->id,
            'workable_type' => 'equipment',
        ]);

        $response = $this->getJson('/api/works/workable/' . $equipment->id . '?workable_type=equipment');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => ['*' => $this->jsonWorkable],
        ]);
    }    
}
