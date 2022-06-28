<?php

namespace Tests\Feature\API\V1;

use App\Models\Employee;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class EmployeeControllerTest extends TestCase
{
    use RefreshDatabase;

    private $jsonEmployee = [
        'id',
        'surname',
        'name',
        'patronymic',
        'email',
        'role',
    ];

    /**
     * @return void
     */
    public function test_gets_a_list_of_employee()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        Employee::factory(9)->create();
        $response = $this->get('/api/employees');
        $response->assertStatus(200);
        $response->assertJsonCount(10, 'data');
        $response->assertJsonStructure([
            'data' => [
                '*' => $this->jsonEmployee,
            ],
        ]);
    }

    /**
     * @return void
     */
    public function test_stores_a_new_employee()
    {
        $role = Role::create(['name' => 'Администратор']);
        Sanctum::actingAs(Employee::factory()->create(['role_id' => $role->id]), ['*']);

        $response = $this->post('/api/employees', [
            'surname' => 'Иванов',
            'name' => 'Иван',
            'patronymic' => 'Иванович',
            'email' => 'test@gmail.com',
            'password' => '123456',
            'role_id' => $role->id
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => $this->jsonEmployee,
        ]);
    }

    /**
     * @return void
     */
    public function test_shows_a_employee()
    {
        Sanctum::actingAs(Employee::factory()->create(), ['*']);

        $employee = Employee::factory()->create();
        $response = $this->get('api/employees/' . $employee->id);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => $this->jsonEmployee,
        ]);
    }

    /**
     * @return void
     */
    public function test_updates_a_employee()
    {
        $role = Role::create(['name' => 'Администратор']);
        Sanctum::actingAs(Employee::factory()->create(['role_id' => $role->id]), ['*']);

        $response = $this->put('api/employees/' . auth()->user()->id, [
            'surname' => 'Иванов',
            'name' => 'Иван',
            'patronymic' => 'Иванович',
            'email' => 'test@gmail.com',
            'password' => '123456',
            'role_id' => $role->id
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => $this->jsonEmployee,
        ]);
        $this->assertDatabaseHas('employees', [
            'surname' => 'Иванов',
            'name' => 'Иван',
            'patronymic' => 'Иванович',
            'email' => 'test@gmail.com',
            'role_id' => $role->id
        ]);
    }

    /**
     * @return void
     */
    public function test_deletes_a_employee()
    {
        $role = Role::create(['name' => 'Администратор']);
        Sanctum::actingAs(Employee::factory()->create(['role_id' => $role->id]), ['*']);

        $employee = Employee::factory()->create();
        $response = $this->delete('api/employees/' . $employee->id);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('employees', [
            'id' => $employee->id,
        ]);
    }
}
