<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        factory(Role::class)->create();
    }

    /**@test */
    public function testUserApiUnAuthRedirectToLogin()
    {
        $response = $this->post('api/users', array_merge($this->data(), ['api_token' => '']));

        $response->assertRedirect('/login');
        $this->assertCount(1, User::all());
    }
    /**@test */
    public function testUserCanBeCreated()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('api/users', $this->data());
        $user = User::where('id', 2)->get();
        $user = $user[0];

        $this->assertCount(2, User::all());
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email
            ],
            'links' => [
                'self' => $user->path()
            ]
        ]);
    }
    /**@test */
    public function testUserRequiredFields()
    {
        collect(['name', 'email', 'password'])
            ->each(function ($field) {
                $response = $this->post('api/users', array_merge($this->data(), [$field => '']));
                $response->assertSessionHasErrors($field);
            });
    }
    /**@test */
    public function testUserCanBeRetrieved()
    {
        $user = factory(User::class)->create();
        $response = $this->get('api/users/' . $user->id . '?api_token=' . $this->user->api_token);
        $response->assertJson([
            'data' => [
                'name' => $user->name,
                'email' => $user->email
            ]
        ]);
    }
    /**@test */
    public function testUsersCanBeRetrieved()
    {
        $role = factory(User::class)->create();
        $role = factory(User::class)->create();

        $response = $this->get('api/users' . '?api_token=' . $this->user->api_token);
        $response->assertJsonCount(3, 'data');
    }
    /**@test */
    public function testUserCanBeUpdated()
    {
        $user = factory(User::class)->create();

        $response = $this->put('api/users/' . $user->id, $this->data());
        $user = User::where('id', 2)->get();
        $user = $user[0];

        $this->assertEquals('Test User', $user->name);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email
            ],
            'links' => [
                'self' => $user->path()
            ]
        ]);
    }
    /**@test */
    public function testUserCanBeDeleted()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();

        $this->assertCount(2, User::all());

        $response = $this->delete('api/users/' . $user->id, ['api_token' => $this->user->api_token]);

        $this->assertCount(1, User::all());
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
    /**@test */
    public function testRolesCanBeAssignedToUser()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $response = $this->get('api/users/' . $user->id . '?api_token=' . $this->user->api_token . '&show-roles=1');
        $this->assertCount(0, $response['data']['roles']);

        factory(Role::class)->create();
        factory(Role::class)->create();
        $roles = json_decode($this->get('api/roles' . '?api_token=' . $this->user->api_token)->getContent(), true);
        $rolesArray = array();
        foreach ($roles['data'] as $role) {
            $rolesArray[] = $role['data']['id'];
        }
        $response = $this->put('api/users/' . $user->id . '?show-roles=1', array_merge($this->data(), [
            'roles' => $rolesArray
        ]));
        $this->assertCount(3, $response['data']['roles']);
    }
    public function testRolesCanBeRemovedFromUser()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $response = $this->get('api/users/' . $user->id . '?api_token=' . $this->user->api_token . '&show-roles=1');

        factory(Role::class)->create();
        factory(Role::class)->create();
        $roles = json_decode($this->get('api/roles' . '?api_token=' . $this->user->api_token)->getContent(), true);
        $rolesArray = array();
        foreach ($roles['data'] as $role) {
            $rolesArray[] = $role['data']['id'];
        }

        $response = $this->put('api/users/' . $user->id . '?show-roles=1', array_merge($this->data(), [
            'roles' => $rolesArray
        ]));
        $this->assertCount(3, $response['data']['roles']);

        $rolesArray = array();
        $response = $this->put('api/users/' . $user->id . '?show-roles=1', array_merge($this->data(), [
            'name' => 'Role 2',
            'slug' => 'role-2',
            'roles' => $rolesArray
        ]));
        $this->assertCount(0, $response['data']['roles']);
    }

    private function data()
    {
        return [
            'name' => 'Test User',
            'email' => 'email@test.com',
            'password' => 'password',
            'roles' => '',
            'api_token' => $this->user->api_token
        ];
    }
}
