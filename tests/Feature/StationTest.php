<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use App\Station;
use App\Permission;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StationTest extends TestCase
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
        factory(Permission::class)->create(['slug' => 'station-viewAny']);
        factory(Permission::class)->create(['slug' => 'station-view']);
        factory(Permission::class)->create(['slug' => 'station-create']);
        factory(Permission::class)->create(['slug' => 'station-update']);
        factory(Permission::class)->create(['slug' => 'station-delete']);

        $this->user->roles[0]->permissions()->sync([1, 2, 3, 4, 5]);
    }

    /**@test */
    public function testStationUnAuthRedirectToLogin()
    {
        $response = $this->post('api/stations', array_merge($this->data(), ['api_token' => '']));

        $response->assertRedirect('/login');
        $this->assertCount(0, Station::all());
    }
    /**@test */
    public function testStationCanBeCreated()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('api/stations', $this->data());
        $station = Station::first();

        $this->assertCount(1, Station::all());
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'data' => [
                'id' => $station->id,
                'name' => $station->name
            ],
            'links' => [
                'self' => $station->path()
            ]
        ]);
    }
    /**@test */
    public function testForbiddenStationCreate()
    {
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->post('api/stations', $this->data());
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testStationNameIsRequired()
    {
        $response = $this->post('api/stations', array_merge($this->data(), ['name' => '']));
        $response->assertSessionHasErrors('name');
    }
    /**@test */
    public function testStationCanBeRetrieved()
    {
        $station = factory(Station::class)->create();
        $response = $this->get('api/stations/' . $station->id . '?api_token=' . $this->user->api_token);
        $response->assertJson([
            'data' => [
                'name' => $station->name
            ]
        ]);
    }
    /**@test */
    public function testForbiddenStationRetrieve()
    {
        $station = factory(Station::class)->create();
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->get('api/stations/' . $station->id . '?api_token=' . $this->user->api_token);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testStationsCanBeRetrieved()
    {
        $station = factory(Station::class)->create();
        $station2 = factory(Station::class)->create();
        $response = $this->get('api/stations' . '?api_token=' . $this->user->api_token);
        $response->assertJsonCount(2, 'data');
    }
    /**@test */
    public function testForbiddenStationsRetrieve()
    {
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->get('api/stations' . '?api_token=' . $this->user->api_token);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testStationCanBeUpdated()
    {
        $this->withoutExceptionHandling();

        $station = factory(Station::class)->create();
        $response =$this->patch('api/stations/' . $station->id, array_merge($this->data(), ['name' => 'Septemvri']));
        $station = Station::first();

        $this->assertEquals('Septemvri', $station->name);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'data' => [
                'id' => $station->id,
                'name' => $station->name
            ],
            'links' => [
                'self' => $station->path()
            ]
        ]);
    }
    /**@test */
    public function testForbiddenStationUpdate()
    {
        $station = factory(Station::class)->create();
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->patch('api/stations/' . $station->id, array_merge($this->data(), ['name' => 'Septemvri']));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testStationCanBeDeleted()
    {
        $this->withoutExceptionHandling();

        $station = factory(Station::class)->create();

        $this->assertCount(1, Station::all());

        $response = $this->delete('api/stations/' . $station->id, ['api_token' => $this->user->api_token]);

        $this->assertCount(0, Station::all());
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
    /**@test */
    public function testForbiddenStationDelete()
    {
        $station = factory(Station::class)->create();
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->delete('api/stations/' . $station->id, ['api_token' => $this->user->api_token]);
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
