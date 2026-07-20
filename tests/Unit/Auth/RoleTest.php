<?php

namespace Tests\Unit\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Company;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_has_correct_role(): void
    {
        $user = User::factory()->superAdmin()->create();
        $this->assertTrue($user->isSuperAdmin());
        $this->assertFalse($user->isAdmin());
        $this->assertFalse($user->isEmployee());
    }

    public function test_admin_has_correct_role(): void
    {
        $admin = User::factory()->admin()->create();
        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($admin->isSuperAdmin());
        $this->assertFalse($admin->isEmployee());
    }

    public function test_employee_has_correct_role(): void
    {
        $employee = User::factory()->employee()->create();
        $this->assertTrue($employee->isEmployee());
        $this->assertFalse($employee->isSuperAdmin());
        $this->assertFalse($employee->isAdmin());
    }

    public function test_super_admin_redirects_to_super_admin_dashboard(): void
    {
        $user = User::factory()->superAdmin()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertRedirect('/super-admin/dashboard');
    }

    public function test_admin_redirects_to_admin_dashboard(): void
    {
        $company = Company::factory()->create();
        $admin = User::factory()->admin()->for($company)->create();

        $response = $this->actingAs($admin)->get('/dashboard');

        $response->assertRedirect('/admin/dashboard');
    }

    public function test_employee_redirects_to_employee_dashboard(): void
    {
        $company = Company::factory()->create();
        $employee = User::factory()->employee()->for($company)->create();

        $response = $this->actingAs($employee)->get('/dashboard');

        $response->assertRedirect('/dashboard/employee');
    }

    public function test_super_admin_cannot_access_admin_routes(): void
    {
        $user = User::factory()->superAdmin()->create();

        $response = $this->actingAs($user)->get('/admin/dashboard');
        $response->assertForbidden();
    }

    public function test_employee_cannot_access_admin_routes(): void
    {
        $company = Company::factory()->create();
        $employee = User::factory()->employee()->for($company)->create();

        $response = $this->actingAs($employee)->get('/admin/dashboard');
        $response->assertForbidden();
    }

    public function test_admin_cannot_access_super_admin_routes(): void
    {
        $company = Company::factory()->create();
        $admin = User::factory()->admin()->for($company)->create();

        $response = $this->actingAs($admin)->get('/super-admin/dashboard');
        $response->assertForbidden();
    }

    public function test_guest_redirected_to_login(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_unauthenticated_user_redirected_from_all_routes(): void
    {
        $routes = ['/admin/dashboard', '/dashboard/employee', '/super-admin/dashboard'];
        
        foreach ($routes as $route) {
            $response = $this->get($route);
            $response->assertRedirect('/login');
        }
    }
}
