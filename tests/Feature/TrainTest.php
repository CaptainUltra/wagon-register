<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use App\Train;
use App\Permission;
use App\WagonType;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TrainTest extends TestCase
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
        factory(Permission::class)->create(['slug' => 'train-viewAny']);
        factory(Permission::class)->create(['slug' => 'train-view']);
        factory(Permission::class)->create(['slug' => 'train-create']);
        factory(Permission::class)->create(['slug' => 'train-update']);
        factory(Permission::class)->create(['slug' => 'train-delete']);
        factory(Permission::class)->create(['slug' => 'wagontype-viewAny']);

        $this->user->roles[0]->permissions()->sync([1, 2, 3, 4, 5, 6]);
    }

    /**@test */
    public function testTrainUnAuthRedirectToLogin()
    {
        $response = $this->post('api/trains', array_merge($this->data(), ['api_token' => '']));

        $response->assertRedirect('/login');
        $this->assertCount(0, Train::all());
    }
    /**@test */
    public function testTrainCanBeCreated()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('api/trains', $this->data());
        $train = Train::first();

        $this->assertCount(1, Train::all());
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'data' => [
                'id' => $train->id,
                'number' => $train->number,
                'route' => $train->route,
            ],
            'links' => [
                'self' => $train->path()
            ]
        ]);
    }
    /**@test */
    public function testForbiddenTrainCreate()
    {
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->post('api/trains', $this->data());
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testTrainRequiredFields()
    {
        collect(['number', 'route'])
            ->each(function ($field) {
                $response = $this->post('api/trains', array_merge($this->data(), [$field => '']));
                $response->assertSessionHasErrors($field);
            });
    }
    /**@test */
    public function testTrainCanBeRetrieved()
    {
        $train = factory(Train::class)->create();
        $response = $this->get('api/trains/' . $train->id . '?api_token=' . $this->user->api_token);
        $response->assertJson([
            'data' => [
                'number' => $train->number,
                'route' => $train->route
            ]
        ]);
    }
    /**@test */
    public function testForbiddenTrainRetrieve()
    {
        $train = factory(Train::class)->create();
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->get('api/trains/' . $train->id . '?api_token=' . $this->user->api_token);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testTrainsCanBeRetrieved()
    {
        $train = factory(Train::class)->create();
        $train2 = factory(Train::class)->create();
        $response = $this->get('api/trains' . '?api_token=' . $this->user->api_token);
        $response->assertJsonCount(2, 'data');
    }
    /**@test */
    public function testForbiddenTrainsRetrieve()
    {
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->get('api/trains' . '?api_token=' . $this->user->api_token);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testTrainCanBeUpdated()
    {
        $this->withoutExceptionHandling();

        $train = factory(Train::class)->create();
        $response =$this->patch('api/trains/' . $train->id, array_merge($this->data(), ['number' => '8602']));
        $train = Train::first();

        $this->assertEquals('8602', $train->number);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'data' => [
                'id' => $train->id,
                'number' => $train->number,
                'route' => $train->route
            ],
            'links' => [
                'self' => $train->path()
            ]
        ]);
    }
    /**@test */
    public function testForbiddenTrainUpdate()
    {
        $train = factory(Train::class)->create();
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->patch('api/trains/' . $train->id, array_merge($this->data(), ['name' => 'Septemvri']));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testTrainCanBeDeleted()
    {
        $this->withoutExceptionHandling();

        $train = factory(Train::class)->create();

        $this->assertCount(1, Train::all());

        $response = $this->delete('api/trains/' . $train->id, ['api_token' => $this->user->api_token]);

        $this->assertCount(0, Train::all());
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
    /**@test */
    public function testForbiddenTrainDelete()
    {
        $train = factory(Train::class)->create();
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->delete('api/trains/' . $train->id, ['api_token' => $this->user->api_token]);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testWagonTypesCanBeAddedToTrain()
    {
        $this->withoutExceptionHandling();
        $train = factory(Train::class)->create();
        $response = $this->get('api/trains/' . $train->id . '?api_token=' . $this->user->api_token);
        $this->assertCount(0, $response['data']['wagontypes']);

        factory(WagonType::class)->create();
        factory(WagonType::class)->create();
        $wagonTypes = json_decode($this->get('api/wagontypes' . '?api_token=' . $this->user->api_token)->getContent(), true);
        $wagonTypesArray = array();
        foreach ($wagonTypes['data'] as $wagonType) {
            $wagonTypesArray[] = $wagonType['data']['id'];
        }

        $response = $this->put('api/trains/' . $train->id . '?show-roles=1', array_merge($this->data(), [
            'name' => 'Role 2',
            'slug' => 'role-2',
            'wagontypes' => $wagonTypesArray
        ]));
        $this->assertCount(2, $response['data']['wagontypes']);
    }
    /**@test */
    public function testWagonTypesCanBeRemovedFromTrain()
    {
        $this->withoutExceptionHandling();
        $train = factory(Train::class)->create();
        $response = $this->get('api/trains/' . $train->id . '?api_token=' . $this->user->api_token);

        $wagonTypesArray = array();

        $response = $this->put('api/trains/' . $train->id . '?show-roles=1', array_merge($this->data(), [
            'name' => 'Role 2',
            'slug' => 'role-2',
            'wagontypes' => $wagonTypesArray
        ]));
        $this->assertCount(0, $response['data']['wagontypes']);
    }
    private function data()
    {
        return [
            'number' => '8601',
            'route' => 'София - Пловдив - Бургас',
            'api_token' => $this->user->api_token
        ];
    }
}
