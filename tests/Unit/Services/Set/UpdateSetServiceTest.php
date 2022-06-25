<?php

namespace Tests\Unit\Services\Set;

use App\Models\Employee;
use App\Models\Equipment\Equipment;
use App\Models\Equipment\EquipmentType;
use App\Models\Equipment\Set;
use App\Models\Role;
use App\Services\Set\UpdateSetService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateSetServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_updates_a_set()
    {
        Role::factory()->create();
        $employee1 = Employee::factory()->create();
        $employee2 = Employee::factory()->create();

        $set = Set::factory()->create([
            'employee_id' => $employee1->id,
        ]);

        $data = [
            'id' => $set->id,
            'name' => 'UpdatedTestSet',
            'employee_id' => $employee2->id,
        ];

        $set = app(UpdateSetService::class)->execute($data);

        $this->assertDatabaseHas('sets', [
            'id' => $set->id,
            'name' => 'UpdatedTestSet',
            'employee_id' => $employee2->id,
        ]);

        $this->assertInstanceOf(Set::class, $set);
    }

    /**
     * @return void
     */
    public function test_updates_a_set_with_equipment()
    {
        Role::factory()->create();
        Employee::factory()->create();
        EquipmentType::factory()->create();
        
        $equipment1 = Equipment::factory()->create();
        $equipment2 = Equipment::factory()->create();

        $set = Set::factory()->create();
        $set->equipment()->attach([$equipment1->id]);

        $data = [
            'id' => $set->id,
            'name' => 'UpdatedTestSet',
            'equipment' => [$equipment2->id],
        ];

        $set = app(UpdateSetService::class)->execute($data);

        $this->assertDatabaseHas('sets', [
            'id' => $set->id,
            'name' => 'UpdatedTestSet',
        ]);

        $this->assertInstanceOf(Set::class, $set);

        $this->assertDatabaseHas('equipment_set', [
            'set_id' => $set->id,
            'equipment_id' => $equipment2->id,
        ]);

        $this->assertDatabaseMissing('equipment_set', [
            'set_id' => $set->id,
            'equipment_id' => $equipment1->id,
        ]);
    }
}
