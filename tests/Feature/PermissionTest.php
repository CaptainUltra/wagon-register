<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use App\Permission;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PermissionTest extends TestCase
{
    use RefreshDatabase;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $role = factory(Role::class)->create();
        $this->user->roles()->sync($role);
        factory(Permission::class)->create(['slug' => 'permission-viewAny']);
        factory(Permission::class)->create(['slug' => 'permission-view']);
        $this->user->roles[0]->permissions()->sync([1, 2]);
    }

    /**@test */
    public function testPermissionUnAuthRedirectToLogin()
    {
        $permission = factory(Permission::class)->create();
        $response = $this->get('api/permissions/' . $permission->id . '?api_token=');

        $response->assertRedirect('/login');
    }
    /**@test */
    public function testPermissionCanBeRetrieved()
    {
        $permission = factory(Permission::class)->create();
        $response = $this->get('api/permissions/' . $permission->id . '?api_token=' . $this->user->api_token);
        $response->assertJson([
            'data' => [
                'name' => $permission->name
            ]
        ]);
    }
    /**@test */
    public function testPermissionsCanBeRetrieved()
    {
        factory(Permission::class)->create();
        factory(Permission::class)->create();
        $response = $this->get('api/permissions' . '?api_token=' . $this->user->api_token);

        $response->assertJsonCount(4, 'data');
    }
}
