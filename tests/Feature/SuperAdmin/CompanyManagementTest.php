<?php

namespace Tests\Feature\SuperAdmin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Company;

class CompanyManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->superAdmin = User::factory()->superAdmin()->create();
    }

    public function test_super_admin_can_view_company_list(): void
    {
        Company::factory(5)->create();

        $response = $this->actingAs($this->superAdmin)
            ->get('/super-admin/companies');

        $response->assertOk();
        $response->assertViewIs('super-admin.companies.index');
        $response->assertViewHas('companies');
    }

    public function test_super_admin_can_view_create_company_form(): void
    {
        $response = $this->actingAs($this->superAdmin)
            ->get('/super-admin/companies/create');

        $response->assertOk();
        $response->assertViewIs('super-admin.companies.create');
    }

    public function test_super_admin_can_create_company(): void
    {
        $data = [
            'name' => 'New Test Company',
            'domain' => 'newtest.toybits.cloud',
            'admin_name' => 'Test Admin',
            'admin_email' => 'admin@newtest.com',
        ];

        $response = $this->actingAs($this->superAdmin)
            ->post('/super-admin/companies', $data);

        $response->assertRedirect('/super-admin/companies');
        $this->assertDatabaseHas('companies', ['name' => 'New Test Company']);
    }

    public function test_creating_company_also_creates_admin_user(): void
    {
        $data = [
            'name' => 'Acme Corp',
            'domain' => 'acme.toybits.cloud',
            'admin_name' => 'Jane Admin',
            'admin_email' => 'jane@acme.com',
        ];

        $response = $this->actingAs($this->superAdmin)
            ->post('/super-admin/companies', $data);

        $response->assertRedirect('/super-admin/companies');
        
        $company = Company::where('name', 'Acme Corp')->first();
        $this->assertNotNull($company);
        
        $this->assertDatabaseHas('users', [
            'email' => 'jane@acme.com',
            'role' => 'admin',
            'company_id' => $company->id,
        ]);
    }

    public function test_super_admin_can_view_company_detail(): void
    {
        $company = Company::factory()->create();

        $response = $this->actingAs($this->superAdmin)
            ->get("/super-admin/companies/{$company->id}");

        $response->assertOk();
        $response->assertViewHas('company');
    }

    public function test_super_admin_can_update_company(): void
    {
        $company = Company::factory()->create();

        $response = $this->actingAs($this->superAdmin)
            ->put("/super-admin/companies/{$company->id}", [
                'name' => 'Updated Name',
            ]);

        $response->assertRedirect('/super-admin/companies');
        $this->assertDatabaseHas('companies', ['name' => 'Updated Name']);
    }

    public function test_super_admin_can_suspend_company(): void
    {
        $company = Company::factory()->create();

        $response = $this->actingAs($this->superAdmin)
            ->post("/super-admin/companies/{$company->id}/suspend");

        $response->assertRedirect('/super-admin/companies');
        $this->assertEquals('suspended', $company->fresh()->status);
    }

    public function test_super_admin_can_reactivate_company(): void
    {
        $company = Company::factory()->suspended()->create();

        $response = $this->actingAs($this->superAdmin)
            ->post("/super-admin/companies/{$company->id}/activate");

        $response->assertRedirect('/super-admin/companies');
        $this->assertEquals('active', $company->fresh()->status);
    }

    public function test_super_admin_can_view_company_admins(): void
    {
        $company = Company::factory()->create();
        User::factory(3)->admin()->for($company)->create();

        $response = $this->actingAs($this->superAdmin)
            ->get("/super-admin/companies/{$company->id}/admins");

        $response->assertOk();
        $response->assertViewHas('admins');
    }

    public function test_non_super_admin_cannot_access_super_admin_pages(): void
    {
        $company = Company::factory()->create();
        $admin = User::factory()->admin()->for($company)->create();

        $response = $this->actingAs($admin)->get('/super-admin/companies');
        $response->assertForbidden();
    }
}
