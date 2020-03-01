<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use App\Status;
use App\Permission;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StatusTest extends TestCase
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
        factory(Permission::class)->create(['slug' => 'status-viewAny']);
        factory(Permission::class)->create(['slug' => 'status-view']);
        factory(Permission::class)->create(['slug' => 'status-create']);
        factory(Permission::class)->create(['slug' => 'status-update']);
        factory(Permission::class)->create(['slug' => 'status-delete']);

        $this->user->roles[0]->permissions()->sync([1, 2, 3, 4, 5]);
    }

    /**@test */
    public function testStatusUnAuthRedirectToLogin()
    {
        $response = $this->post('api/statuses', array_merge($this->data(), ['api_token' => '']));

        $response->assertRedirect('/login');
        $this->assertCount(0, Status::all());
    }
    /**@test */
    public function testStatusCanBeCreated()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('api/statuses', $this->data());
        $status = Status::first();

        $this->assertCount(1, Status::all());
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'data' => [
                'id' => $status->id,
                'name' => $status->name
            ],
            'links' => [
                'self' => $status->path()
            ]
        ]);
    }
    /**@test */
    public function testForbiddenStatusCreate()
    {
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->post('api/statuses', $this->data());
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testStatusNameIsRequired()
    {
        $response = $this->post('api/statuses', array_merge($this->data(), ['name' => '']));
        $response->assertSessionHasErrors('name');
    }
    /**@test */
    public function testStatusCanBeRetrieved()
    {
        $status = factory(Status::class)->create();
        $response = $this->get('api/statuses/' . $status->id . '?api_token=' . $this->user->api_token);
        $response->assertJson([
            'data' => [
                'name' => $status->name
            ]
        ]);
    }
    /**@test */
    public function testForbiddenStatusRetrieve()
    {
        $status = factory(Status::class)->create();
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->get('api/statuses/' . $status->id . '?api_token=' . $this->user->api_token);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testStatusesCanBeRetrieved()
    {
        $status = factory(Status::class)->create();
        $status2 = factory(Status::class)->create();
        $response = $this->get('api/statuses' . '?api_token=' . $this->user->api_token);
        $response->assertJsonCount(2, 'data');
    }
    /**@test */
    public function testForbiddenStatusesRetrieve()
    {
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->get('api/statuses' . '?api_token=' . $this->user->api_token);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testStatusCanBeUpdated()
    {
        $this->withoutExceptionHandling();

        $status = factory(Status::class)->create();
        $response =$this->patch('api/statuses/' . $status->id, array_merge($this->data(), ['name' => 'Scrapped']));
        $status = Status::first();

        $this->assertEquals('Scrapped', $status->name);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'data' => [
                'id' => $status->id,
                'name' => $status->name
            ],
            'links' => [
                'self' => $status->path()
            ]
        ]);
    }
    /**@test */
    public function testForbiddenStatusUpdate()
    {
        $status = factory(Status::class)->create();
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->patch('api/statuses/' . $status->id, array_merge($this->data(), ['name' => 'Septemvri']));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testStatusCanBeDeleted()
    {
        $this->withoutExceptionHandling();

        $status = factory(Status::class)->create();

        $this->assertCount(1, Status::all());

        $response = $this->delete('api/statuses/' . $status->id, ['api_token' => $this->user->api_token]);

        $this->assertCount(0, Status::all());
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
    /**@test */
    public function testForbiddenStatusDelete()
    {
        $status = factory(Status::class)->create();
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->delete('api/statuses/' . $status->id, ['api_token' => $this->user->api_token]);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**
     * Get testing data
     * 
     * @return mixed
     */
    private function data()
    {
        return [
            'name' => 'Expired Revision',
            'api_token' => $this->user->api_token
        ];
    }
}
