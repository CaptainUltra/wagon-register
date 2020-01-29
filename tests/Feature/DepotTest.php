<?php

namespace Tests\Feature;

use App\Depot;
use App\Permission;
use App\Role;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class DepotTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();

        //Set up role and permissions for the user
        $role = factory(Role::class)->create();
        $this->user->roles()->sync($role);
        factory(Permission::class)->create(['slug' => 'depot-viewAny']);
        factory(Permission::class)->create(['slug' => 'depot-view']);
        factory(Permission::class)->create(['slug' => 'depot-create']);
        factory(Permission::class)->create(['slug' => 'depot-update']);
        factory(Permission::class)->create(['slug' => 'depot-delete']);

        $this->user->roles[0]->permissions()->sync([1, 2, 3, 4, 5]);
    }

    /**@test */
    public function testUnAuthRedirectToLogin()
    {
        $response = $this->post('api/depots', array_merge($this->data(), ['api_token' => '']));

        $response->assertRedirect('/login');
        $this->assertCount(0, Depot::all());
    }
    /**@test */
    public function testDepotCanBeCreated()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('api/depots', $this->data());
        $depot = Depot::first();

        $this->assertCount(1, Depot::all());
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'data' => [
                'id' => $depot->id,
                'name' => $depot->name
            ],
            'links' => [
                'self' => $depot->path()
            ]
        ]);
    }
    /**@test */
    public function testForbiddenDepotCreate()
    {
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->post('api/depots', $this->data());
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testNameIsRequired()
    {
        $response = $this->post('api/depots', array_merge($this->data(), ['name' => '']));
        $response->assertSessionHasErrors('name');
    }
    /**@test */
    public function testDepotCanBeRetrieved()
    {
        $depot = factory(Depot::class)->create();
        $response = $this->get('api/depots/' . $depot->id . '?api_token=' . $this->user->api_token);
        $response->assertJson([
            'data' => [
                'name' => $depot->name
            ]
        ]);
    }
    /**@test */
    public function testForbiddenDepotRetrieve()
    {
        $depot = factory(Depot::class)->create();
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->get('api/depots/' . $depot->id . '?api_token=' . $this->user->api_token);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testDepotsCanBeRetrieved()
    {
        $depot = factory(Depot::class)->create();
        $depot2 = factory(Depot::class)->create();
        $response = $this->get('api/depots' . '?api_token=' . $this->user->api_token);
        $response->assertJsonCount(2, 'data');
    }
    /**@test */
    public function testForbiddenDepotsRetrieve()
    {
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->get('api/depots' . '?api_token=' . $this->user->api_token);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testDepotCanBeUpdated()
    {
        $this->withoutExceptionHandling();

        $depot = factory(Depot::class)->create();
        $response =$this->patch('api/depots/' . $depot->id, array_merge($this->data(), ['name' => 'Septemvri']));
        $depot = Depot::first();

        $this->assertEquals('Septemvri', $depot->name);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'data' => [
                'id' => $depot->id,
                'name' => $depot->name
            ],
            'links' => [
                'self' => $depot->path()
            ]
        ]);
    }
    /**@test */
    public function testForbiddenDepotUpdate()
    {
        $depot = factory(Depot::class)->create();
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->patch('api/depots/' . $depot->id, array_merge($this->data(), ['name' => 'Septemvri']));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testDepotCanBeDeleted()
    {
        $this->withoutExceptionHandling();

        $depot = factory(Depot::class)->create();

        $this->assertCount(1, Depot::all());

        $response = $this->delete('api/depots/' . $depot->id, ['api_token' => $this->user->api_token]);

        $this->assertCount(0, Depot::all());
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
    /**@test */
    public function testForbiddenDepotDelete()
    {
        $depot = factory(Depot::class)->create();
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->delete('api/depots/' . $depot->id, ['api_token' => $this->user->api_token]);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    private function data()
    {
        return [
            'name' => 'Sofia',
            'api_token' => $this->user->api_token
        ];
    }
}
