<?php

namespace Tests\Feature;

use App\Permission;
use App\Role;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleTest extends TestCase
{
    use RefreshDatabase;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $role = factory(Role::class)->create();
        $this->user->roles()->sync($role);
        factory(Permission::class)->create(['slug' => 'role-viewAny']);
        factory(Permission::class)->create(['slug' => 'role-view']);
        factory(Permission::class)->create(['slug' => 'role-create']);
        factory(Permission::class)->create(['slug' => 'role-update']);
        factory(Permission::class)->create(['slug' => 'role-delete']);
        factory(Permission::class)->create(['slug' => 'permission-viewAny']);

        $this->user->roles[0]->permissions()->sync([1, 2, 3, 4, 5, 6]);
    }

    /**@test */
    public function testRoleUnAuthRedirectToLogin()
    {
        $response = $this->post('api/roles', array_merge($this->data(), ['api_token' => '']));

        $response->assertRedirect('/login');
        $this->assertCount(1, Role::all());
    }
    /**@test */
    public function testRoleCanBeCreated()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('api/roles', $this->data());
        $role = Role::where('id', 2)->first();

        $this->assertCount(2, Role::all());
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'data' => [
                'id' => $role->id,
                'name' => $role->name
            ],
            'links' => [
                'self' => $role->path()
            ]
        ]);
    }
    /**@test */
    public function testForbiddenRoleCreate()
    {
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->post('api/roles', $this->data());
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testRoleRequiredFields()
    {
        collect(['name', 'slug'])
            ->each(function ($field) {
                $response = $this->post('api/roles', array_merge($this->data(), [$field => '']));
                $response->assertSessionHasErrors($field);
            });
    }
    /**@test */
    public function testRoleCanBeRetrieved()
    {
        $role = factory(Role::class)->create();
        $response = $this->get('api/roles/' . $role->id . '?api_token=' . $this->user->api_token);
        $response->assertJson([
            'data' => [
                'name' => $role->name
            ]
        ]);
    }
    /**@test */
    public function testForbiddenRoleRetrieve()
    {
        $depot = factory(Role::class)->create();
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->get('api/roles/' . $depot->id . '?api_token=' . $this->user->api_token);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testRolesCanBeRetrieved()
    {
        $role = factory(Role::class)->create();
        $role = factory(Role::class)->create();

        $response = $this->get('api/roles' . '?api_token=' . $this->user->api_token . '&show-permissions=1');
        $response->assertJsonCount(3, 'data');
    }
    /**@test */
    public function testForbiddenRolesRetrieve()
    {
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->get('api/roles' . '?api_token=' . $this->user->api_token);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testRoleCanBeUpdated()
    {
        $role = factory(Role::class)->create();

        $response = $this->put('api/roles/' . $role->id, array_merge($this->data(), [
            'name' => 'Role 2',
            'slug' => 'role-2'
        ]));
        $role = Role::where('id', 2)->first();

        $this->assertEquals('Role 2', $role->name);
        $this->assertEquals('role-2', $role->slug);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'data' => [
                'id' => $role->id,
                'name' => $role->name
            ],
            'links' => [
                'self' => $role->path()
            ]
        ]);
    }
    /**@test */
    public function testForbiddenRoleUpdate()
    {
        $role = factory(Role::class)->create();
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->put('api/roles/' . $role->id, array_merge($this->data(), [
            'name' => 'Role 2',
            'slug' => 'role-2'
        ]));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testRoleCanBeDeleted()
    {
        $this->withoutExceptionHandling();
        $role = factory(Role::class)->create();

        $this->assertCount(2, Role::all());

        $response = $this->delete('api/roles/' . $role->id, ['api_token' => $this->user->api_token]);

        $this->assertCount(1, Role::all());
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
    /**@test */
    public function testForbiddenRoleDelete()
    {
        $role = factory(Role::class)->create();
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->delete('api/roles/' . $role->id, ['api_token' => $this->user->api_token]);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testPermissionsCanBeAssingnedToRole()
    {
        $this->withoutExceptionHandling();

        //Create and fetch a role
        $role = factory(Role::class)->create();
        $response = $this->get('api/roles/' . $role->id . '?api_token=' . $this->user->api_token . '&show-permissions=1');
        $this->assertCount(0, $response['data']['permissions']);

        //Create and fetch permissions
        factory(Permission::class)->create();
        factory(Permission::class)->create();
        $permissions = json_decode($this->get('api/permissions' . '?api_token=' . $this->user->api_token)->getContent(), true);

        //Gather permissions' ids into an array 
        $permissionArray = array();
        foreach ($permissions['data'] as $permission) {
            $permissionArray[] = $permission['data']['id'];
        }

        //Update the role with the permissions array
        $response = $this->put('api/roles/' . $role->id . '?show-permissions=1', array_merge($this->data(), [
            'name' => 'Role 2',
            'slug' => 'role-2',
            'permissions' => $permissionArray
        ]));
        $this->assertCount(8, $response['data']['permissions']);
    }
    public function testPermissionsCanBeRemovedFromRole()
    {
        $this->withoutExceptionHandling();

        //Create and fetch a role
        $role = factory(Role::class)->create();
        $response = $this->get('api/roles/' . $role->id . '?api_token=' . $this->user->api_token);

        //Create and fetch permissions
        factory(Permission::class)->create();
        factory(Permission::class)->create();
        $permissions = json_decode($this->get('api/permissions' . '?api_token=' . $this->user->api_token)->getContent(), true);

        //Gather permissions' ids into an array 
        $permissionArray = array();
        foreach ($permissions['data'] as $permission) {
            $permissionArray[] = $permission['data']['id'];
        }

        //Update the role with the permissions array
        $response = $this->put('api/roles/' . $role->id . '?show-permissions=1', array_merge($this->data(), [
            'name' => 'Role 2',
            'slug' => 'role-2',
            'permissions' => $permissionArray
        ]));
        $this->assertCount(8, $response['data']['permissions']);

        $permissionArray = array();
        $response = $this->put('api/roles/' . $role->id, array_merge($this->data(), [
            'name' => 'Role 2',
            'slug' => 'role-2',
            'permissions' => $permissionArray
        ]));

        $response = $this->get('api/roles/' . $role->id . '?api_token=' . $this->user->api_token . '&show-permissions=1');
        $this->assertCount(0, $response['data']['permissions']);
    }
    private function data()
    {
        return [
            'name' => 'Test Role',
            'slug' => 'test-role',
            'permissions' => '',
            'api_token' => $this->user->api_token
        ];
    }
}
