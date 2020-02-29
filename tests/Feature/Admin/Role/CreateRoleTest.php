<?php

namespace Tests\Feature\Admin\Role;

use App\Events\Admin\Auth\Role\RoleCreated;
use App\Models\Auth\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CreateRoleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_admin_can_access_the_create_role_page()
    {
        $this->loginAsAdmin();

        $this->get('/admin/auth/role/create')->assertStatus(200);
    }

    /** @test */
    public function the_name_is_required()
    {
        $this->loginAsAdmin();

        $response = $this->post('/admin/auth/role', ['name' => '']);

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function the_name_must_be_unique()
    {
        $this->loginAsAdmin();

        $response = $this->post('/admin/auth/role', ['name' => config('access.users.admin_role')]);

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function at_least_one_permission_is_required()
    {
        $this->loginAsAdmin();

        $response = $this->post('/admin/auth/role', ['name' => 'new role']);

        $response->assertSessionHas(['flash_danger' => __('exceptions.admin.access.roles.needs_permission')]);
    }

    /** @test */
    public function a_role_can_be_created()
    {
        $this->loginAsAdmin();

        $this->post('/admin/auth/role', ['name' => 'new role', 'permissions' => ['view admin']]);

        $role = Role::where(['name' => 'new role'])->first();

        $this->assertTrue($role->hasPermissionTo('view admin'));
    }

    /** @test */
    public function an_event_gets_dispatched()
    {
        $this->loginAsAdmin();
        Event::fake();

        $this->post('/admin/auth/role', ['name' => 'new role', 'permissions' => ['view admin']]);

        Event::assertDispatched(RoleCreated::class);
    }
}
