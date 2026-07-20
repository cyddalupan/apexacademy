<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Company;
use App\Models\Position;

class EmployeeManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private Company $company;

    protected function setUp(): void
    {
        parent::setUp();
        $this->company = Company::factory()->create();
        $this->admin = User::factory()->admin()->for($this->company)->create();
    }

    public function test_admin_can_view_employee_list(): void
    {
        User::factory(5)->employee()->for($this->company)->create();

        $response = $this->actingAs($this->admin)
            ->get('/admin/employees');

        $response->assertOk();
        $response->assertViewIs('admin.employees.index');
        $response->assertViewHas('employees');
    }

    public function test_admin_can_view_create_employee_form(): void
    {
        $response = $this->actingAs($this->admin)
            ->get('/admin/employees/create');

        $response->assertOk();
        $response->assertViewIs('admin.employees.create');
    }

    public function test_admin_can_create_employee(): void
    {
        $position = Position::factory()->for($this->company)->create();

        $data = [
            'name' => 'John Employee',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'position_id' => $position->id,
        ];

        $response = $this->actingAs($this->admin)
            ->post('/admin/employees', $data);

        $response->assertRedirect('/admin/employees');
        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
            'role' => 'employee',
            'company_id' => $this->company->id,
        ]);
    }

    public function test_admin_can_view_employee_detail(): void
    {
        $employee = User::factory()->employee()->for($this->company)->create();

        $response = $this->actingAs($this->admin)
            ->get("/admin/employees/{$employee->id}");

        $response->assertOk();
        $response->assertViewHas('employee');
    }

    public function test_admin_can_update_employee(): void
    {
        $employee = User::factory()->employee()->for($this->company)->create();

        $response = $this->actingAs($this->admin)
            ->put("/admin/employees/{$employee->id}", [
                'name' => 'Updated Name',
                'email' => $employee->email,
            ]);

        $response->assertRedirect('/admin/employees');
        $this->assertDatabaseHas('users', ['name' => 'Updated Name']);
    }

    public function test_admin_can_view_positions_list(): void
    {
        Position::factory(3)->for($this->company)->create();

        $response = $this->actingAs($this->admin)
            ->get('/admin/positions');

        $response->assertOk();
        $response->assertViewIs('admin.positions.index');
        $response->assertViewHas('positions');
    }

    public function test_admin_can_create_position(): void
    {
        $data = ['title' => 'Graphic Designer', 'description' => 'Design assets'];

        $response = $this->actingAs($this->admin)
            ->post('/admin/positions', $data);

        $response->assertRedirect('/admin/positions');
        $this->assertDatabaseHas('positions', [
            'title' => 'Graphic Designer',
            'company_id' => $this->company->id,
        ]);
    }

    public function test_admin_can_view_position_detail(): void
    {
        $position = Position::factory()->for($this->company)->create();

        $response = $this->actingAs($this->admin)
            ->get("/admin/positions/{$position->id}");

        $response->assertOk();
        $response->assertViewHas('position');
    }

    public function test_admin_cannot_see_other_company_data(): void
    {
        $otherCompany = Company::factory()->create();
        $otherEmployee = User::factory()->employee()->for($otherCompany)->create();

        $response = $this->actingAs($this->admin)
            ->get("/admin/employees/{$otherEmployee->id}");

        $response->assertForbidden();
    }

    public function test_employee_list_only_shows_own_company(): void
    {
        User::factory(3)->employee()->for($this->company)->create();
        User::factory(3)->employee()->for(Company::factory())->create();

        $response = $this->actingAs($this->admin)
            ->get('/admin/employees');

        $response->assertOk();
        $response->assertViewHas('employees', function($employees) {
            return $employees->count() === 3;
        });
    }
}
