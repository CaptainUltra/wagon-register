<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use App\Permission;
use Tests\TestCase;
use App\RevisoryPoint;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RevisoryPointTest extends TestCase
{
    use RefreshDatabase;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();

        $role = factory(Role::class)->create();
        $this->user->roles()->sync($role);
        factory(Permission::class)->create(['slug' => 'revisorypoint-viewAny']);
        factory(Permission::class)->create(['slug' => 'revisorypoint-view']);
        factory(Permission::class)->create(['slug' => 'revisorypoint-create']);
        factory(Permission::class)->create(['slug' => 'revisorypoint-update']);
        factory(Permission::class)->create(['slug' => 'revisorypoint-delete']);
        $this->user->roles[0]->permissions()->sync([1, 2, 3, 4, 5]);
    }

    /**@test */
    public function testUnAuthRedirectToLogin()
    {
        $response = $this->post('api/revisorypoints', array_merge($this->data(), ['api_token' => '']));

        $response->assertRedirect('/login');
        $this->assertCount(0, RevisoryPoint::all());
    }
    /**@test */
    public function testRevisoryPointCanBeCreated()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('api/revisorypoints', $this->data());
        $revisoryPoint = RevisoryPoint::first();

        $this->assertCount(1, RevisoryPoint::all());
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'data' => [
                'id' => $revisoryPoint->id,
                'name' => $revisoryPoint->name,
                'abbreviation' => $revisoryPoint->abbreviation
            ],
            'links' => [
                'self' => $revisoryPoint->path()
            ]
        ]);
    }
    /**@test */
    public function testForbiddenRevisoryPointCreate()
    {
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->post('api/revisorypoints', $this->data());
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testRevisoryPointRequiredFields()
    {
        collect(['name', 'abbreviation'])
            ->each(function ($field) {
                $response = $this->post('api/revisorypoints', array_merge($this->data(), [$field => '']));
                $response->assertSessionHasErrors($field);
            });
    }
    /**@test */
    public function testRevisoryPointCanBeRetrieved()
    {
        $revisoryPoint = factory(RevisoryPoint::class)->create();

        $response = $this->get('api/revisorypoints/' . $revisoryPoint->id . '?api_token=' . $this->user->api_token);
        $response->assertJson([
            'data' => [
                'name' => $revisoryPoint->name,
                'abbreviation' => $revisoryPoint->abbreviation
            ]
        ]);
    }
    /**@test */
    public function testForbiddenRevisoryPointRetrieve()
    {
        $revisoryPoint = factory(RevisoryPoint::class)->create();
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->get('api/revisorypoints/' . $revisoryPoint->id . '?api_token=' . $this->user->api_token);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testRevisoryPointsCanBeRetrieved()
    {
        $revisoryPoint = factory(RevisoryPoint::class)->create();
        $revisoryPoint2 = factory(RevisoryPoint::class)->create();

        $response = $this->get('api/revisorypoints' . '?api_token=' . $this->user->api_token);
        $response->assertJsonCount(2, 'data');
    }
    /**@test */
    public function testForbiddenRevisoryPointsRetrieve()
    {
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->get('api/revisorypoints' . '?api_token=' . $this->user->api_token);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testRevisoryPointCanBeUpdated()
    {
        $this->withoutExceptionHandling();

        $revisoryPoint = factory(RevisoryPoint::class)->create();

        $response = $this->patch('api/revisorypoints/' . $revisoryPoint->id, array_merge($this->data(), [
            'name' => 'Septemvri',
            'abbreviation' => 'Kwg'
        ]));
        $revisoryPoint = RevisoryPoint::first();

        $this->assertEquals('Septemvri', $revisoryPoint->name);
        $this->assertEquals('Kwg', $revisoryPoint->abbreviation);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'data' => [
                'id' => $revisoryPoint->id,
                'name' => $revisoryPoint->name,
                'abbreviation' => $revisoryPoint->abbreviation
            ],
            'links' => [
                'self' => $revisoryPoint->path()
            ]
        ]);
    }
    /**@test */
    public function testForbiddenRevisoryPointUpdate()
    {
        $revisoryPoint = factory(RevisoryPoint::class)->create();
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->patch('api/revisorypoints/' . $revisoryPoint->id, array_merge($this->data(), [
            'name' => 'Septemvri',
            'abbreviation' => 'Kwg'
        ]));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testRevisoryPointCanBeDeleted()
    {
        $this->withoutExceptionHandling();

        $revisoryPoint = factory(RevisoryPoint::class)->create();

        $this->assertCount(1, RevisoryPoint::all());

        $response = $this->delete('api/revisorypoints/' . $revisoryPoint->id, ['api_token' => $this->user->api_token]);

        $this->assertCount(0, RevisoryPoint::all());
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
    /**@test */
    public function testForbiddenRevisoryPointDelete()
    {
        $revisoryPoint = factory(RevisoryPoint::class)->create();
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->delete('api/revisorypoints/' . $revisoryPoint->id, ['api_token' => $this->user->api_token]);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    private function data()
    {
        return [
            'name' => 'Sofia',
            'abbreviation' => 'Nd',
            'api_token' => $this->user->api_token
        ];
    }
}
