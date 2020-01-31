<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use App\Permission;
use Tests\TestCase;
use App\InteriorType;
use PhpParser\Node\Expr\Cast\Int_;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InteriorTypeTest extends TestCase
{
    use RefreshDatabase;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();

        $role = factory(Role::class)->create();
        $this->user->roles()->sync($role);
        factory(Permission::class)->create(['slug' => 'interiortype-viewAny']);
        factory(Permission::class)->create(['slug' => 'interiortype-view']);
        factory(Permission::class)->create(['slug' => 'interiortype-create']);
        factory(Permission::class)->create(['slug' => 'interiortype-update']);
        factory(Permission::class)->create(['slug' => 'interiortype-delete']);
        $this->user->roles[0]->permissions()->sync([1, 2, 3, 4, 5]);
    }

    /**@test */
    public function testUnAuthRedirectToLogin()
    {
        $response = $this->post('api/interiortypes', array_merge($this->data(), ['api_token' => '']));

        $response->assertRedirect('/login');
        $this->assertCount(0, InteriorType::all());
    }
    /**@test */
    public function testInteriorTypeCanBeCreated()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('api/interiortypes', $this->data());
        $interiorType = InteriorType::first();

        $this->assertCount(1, InteriorType::all());
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'data' => [
                'id' => $interiorType->id,
                'name' => $interiorType->name
            ],
            'links' => [
                'self' => $interiorType->path()
            ]
        ]);
    }
    /**@test */
    public function testForbiddenInteriorTypeCreate()
    {
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->post('api/interiortypes', $this->data());
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testNameOfInteriorTypeIsRequired()
    {
        $response = $this->post('api/interiortypes', array_merge($this->data(), ['name' => '']));

        $response->assertSessionHasErrors('name');
    }
    /**@test */
    public function testInteriorTypeCanBeRetrieved()
    {
        $interiorType = factory(InteriorType::class)->create();
        $response = $this->get('api/interiortypes/' . $interiorType->id . '?api_token=' . $this->user->api_token);
        $response->assertJson([
            'data' => [
                'name' => $interiorType->name
            ]
        ]);
    }
    /**@test */
    public function testForbiddenInteriorTypeRetriev()
    {
        $interiorType = factory(InteriorType::class)->create();
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->get('api/interiortypes/' . $interiorType->id . '?api_token=' . $this->user->api_token);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testInteriorTypesCanBeRetrieved()
    {
        $interiorType = factory(InteriorType::class)->create();
        $interiorType2 = factory(InteriorType::class)->create();
        $response = $this->get('api/interiortypes/' . '?api_token=' . $this->user->api_token);
        $response->assertJsonCount(2, 'data');
    }
    /**@test */
    public function testForbiddenInteriorTypesRetrieve()
    {
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->get('api/interiortypes' . '?api_token=' . $this->user->api_token);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testInteriorTypeCanBeUpdated()
    {
        $this->withoutExceptionHandling();

        $interiorType = factory(InteriorType::class)->create();
        $response = $this->put('api/interiortypes/' . $interiorType->id, array_merge($this->data(), [
            'name' => 'coupe'
        ]));
        $interiorType = InteriorType::first();

        $this->assertEquals('coupe', $interiorType->name);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'data' => [
                'name' => $interiorType->name
            ],
            'links' => [
                'self' => $interiorType->path()
            ]
        ]);
    }
    /**@test */
    public function testForbiddenInteriorTypeUpdate()
    {
        $interiorType = factory(InteriorType::class)->create();
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->patch('api/interiortypes/' . $interiorType->id, array_merge($this->data(), [
            'name' => 'coupe'
        ]));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testInteriorTypeCanBeDeleted()
    {
        $this->withoutExceptionHandling();

        $interiorType = factory(InteriorType::class)->create();
        $response = $this->delete('api/interiortypes/' . $interiorType->id, ['api_token' => $this->user->api_token]);

        $this->assertCount(0, InteriorType::all());
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
    /**@test */
    public function testForbiddenInteriorTypeDelete()
    {
        $interiorType = factory(InteriorType::class)->create();
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->delete('api/interiortypes/' . $interiorType->id, ['api_token' => $this->user->api_token]);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    private function data()
    {
        return [
            'name' => 'salon',
            'api_token' => $this->user->api_token
        ];
    }
}
