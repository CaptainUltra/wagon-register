<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use App\WagonType;
use App\Permission;
use Tests\TestCase;
use App\InteriorType;
use Illuminate\Http\Resources\Json\Resource;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WagonTypeTest extends TestCase
{
    use RefreshDatabase;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();

        $role = factory(Role::class)->create();
        $this->user->roles()->sync($role);
        factory(Permission::class)->create(['slug' => 'wagontype-viewAny']);
        factory(Permission::class)->create(['slug' => 'wagontype-view']);
        factory(Permission::class)->create(['slug' => 'wagontype-create']);
        factory(Permission::class)->create(['slug' => 'wagontype-update']);
        factory(Permission::class)->create(['slug' => 'wagontype-delete']);
        $this->user->roles[0]->permissions()->sync([1, 2, 3, 4, 5]);
    }

    /**@test */
    public function testUnAuthRedirectToLogin()
    {
        $response = $this->post('api/wagontypes', array_merge($this->data(), ['api_token' => '']));

        $response->assertRedirect('/login');
        $this->assertCount(0, WagonType::all());
    }
    /**@test*/
    public function testWagonTypeCanBeCreated()
    {
        $this->withoutExceptionHandling();
        factory(InteriorType::class)->create()->save();

        $response = $this->post('api/wagontypes', $this->data());
        $wagonType = WagonType::first();

        $this->assertCount(1, WagonType::all());
        $this->assertEquals(1, $wagonType->interior_type_id);
        $this->assertEquals(1, $wagonType->interiorType->id);
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'data' => [
                'id' => $wagonType->id,
                'name' => $wagonType->name,
                'conditioned' => $wagonType->conditioned
            ],
            'links' => [
                'self' => $wagonType->path()
            ]
        ]);
    }
    /**@test */
    public function testForbiddenWagonTypeCreate()
    {
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->post('api/wagontypes', $this->data());
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testInteriorTypeMustBeValid()
    {
        $response = $this->post('api/wagontypes', array_merge($this->data(), ['interior_type_id' => 2]));

        $response->assertSessionHasErrors('interior_type_id');
    }
    /**@test */
    public function testRequiredFields()
    {
        collect(['name', 'conditioned', 'interior_type_id', 'revision_valid_for'])
            ->each(function ($field) {
                $response = $this->post('api/wagontypes', array_merge($this->data(), [$field => '']));
                $response->assertSessionHasErrors($field);
            });
    }
    /**@test*/
    public function testWagonTypeCanBeRetrieved()
    {
        $wagonType = factory(WagonType::class)->create();

        $response = $this->get('api/wagontypes/' . $wagonType->id . '?api_token=' . $this->user->api_token);
        $response->assertJson([
            'data' => [
                'name' => $wagonType->name,
                'conditioned' => $wagonType->conditioned,
            ]
        ]);
    }
    /**@test */
    public function testForbiddenWagonTypeRetrieve()
    {
        $wagonType = factory(WagonType::class)->create();
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->get('api/wagontypes/' . $wagonType->id . '?api_token=' . $this->user->api_token);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testWagonTypesCanBeRetrieved()
    {
        factory(WagonType::class)->create();
        factory(WagonType::class)->create();

        $response = $this->get('api/wagontypes' . '?api_token=' . $this->user->api_token);
        $response->assertJsonCount(2, 'data');
    }
    /**@test */
    public function testForbiddenWagonTypesRetrieve()
    {
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->get('api/wagontypes' . '?api_token=' . $this->user->api_token);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testWagonTypeCanBeUpdated()
    {
        $this->withoutExceptionHandling();
        factory(InteriorType::class)->create()->save();
        factory(InteriorType::class)->create()->save();
        $wagonType = factory(WagonType::class)->create();

        $response = $this->put('api/wagontypes/' . $wagonType->id, array_merge($this->data(), [
            'name' => '21-50',
            'conditioned' => false,
            'interior_type_id' =>  2
        ]));
        $wagonType = WagonType::first();

        $this->assertEquals('21-50', $wagonType->name);
        $this->assertEquals(0, $wagonType->conditioned);
        $this->assertEquals(2, $wagonType->interior_type_id);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'data' => [
                'id' => $wagonType->id
            ],
            'links' => [
                'self' => $wagonType->path()
            ]
        ]);
    }
    /**@test */
    public function testForbiddenWagonTypeUpdate()
    {
        $wagonType = factory(WagonType::class)->create();
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->patch('api/wagontypes/' . $wagonType->id, array_merge($this->data(), [
            'name' => '21-50',
            'conditioned' => false,
            'interior_type_id' =>  2
        ]));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test*/
    public function testWagonTypeCanBeDeleted()
    {
        $this->withoutExceptionHandling();
        $wagonType = factory(WagonType::class)->create();

        $this->assertCount(1, WagonType::all());

        $response = $this->delete('api/wagontypes/' . $wagonType->id, ['api_token' => $this->user->api_token]);

        $this->assertCount(0, WagonType::all());
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
    /**@test */
    public function testForbiddenWagonTypeDelete()
    {
        $wagonType = factory(WagonType::class)->create();
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->delete('api/wagontypes/' . $wagonType->id, ['api_token' => $this->user->api_token]);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    private function data()
    {
        return [
            'name' => '22-97',
            'conditioned' => true,
            'revision_valid_for' => 1,
            'interior_type_id' =>  1,
            'api_token' => $this->user->api_token
        ];
    }
}
