<?php

namespace Tests\Feature\Wagon;

use App\Role;
use App\User;
use App\Depot;
use App\Wagon;
use App\WagonType;
use Carbon\Carbon;
use App\Permission;
use Tests\TestCase;
use App\InteriorType;
use App\RevisoryPoint;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WagonTest extends TestCase
{
    use RefreshDatabase;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        factory(WagonType::class)->create(['name' => '85-97']);
        factory(Depot::class)->create();
        factory(RevisoryPoint::class)->create();

        $role = factory(Role::class)->create();
        $this->user->roles()->sync($role);
        factory(Permission::class)->create(['slug' => 'wagon-viewAny']);
        factory(Permission::class)->create(['slug' => 'wagon-view']);
        factory(Permission::class)->create(['slug' => 'wagon-create']);
        factory(Permission::class)->create(['slug' => 'wagon-update']);
        factory(Permission::class)->create(['slug' => 'wagon-delete']);
        $this->user->roles[0]->permissions()->sync([1, 2, 3, 4, 5]);
    }
    /**@test */
    public function testUnAuthRedirectToLogin()
    {
        $response = $this->post('api/wagons', array_merge($this->data(), ['api_token' => '']));

        $response->assertRedirect('/login');
        $this->assertCount(0, Wagon::all());
    }
    /**@test */
    public function testWagonCanBeCreated()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('api/wagons', $this->data());
        $wagon = Wagon::first();

        $this->assertCount(1, Wagon::all());
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'data' => [
                'id' => $wagon->id
            ],
            'links' => [
                'self' => $wagon->path()
            ]
        ]);
    }
    /**@test */
    public function testForbiddenWagonCreate()
    {
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->post('api/wagons', $this->data());
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testWagonNumberIsRequired()
    {
        $response = $this->post('api/wagons', array_merge($this->data(), ['number' => '']));

        $response->assertSessionHasErrors('number');
    }
    /**@test */
    public function testRervisionDateIsStoredProperly()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('api/wagons', $this->data());
        $this->assertCount(1, Wagon::all());
        $this->assertInstanceOf(Carbon::class, Wagon::first()->revision_date);
        $this->assertInstanceOf(Carbon::class, Wagon::first()->revision_exp_date);
    }
    /**@test */
    public function testWagonCanBeRetrieved()
    {
        $wagon = factory(Wagon::class)->create();
        $response = $this->get('api/wagons/' . $wagon->id . '?api_token=' . $this->user->api_token);
        $response->assertJson([
            'data' => [
                'id' => $wagon->id,
                'number' => $wagon->number,
                'letter_index' => $wagon->letter_index,
                'v_max' => $wagon->v_max,
                'seats' => $wagon->seats,
                'revision_date' => $wagon->revision_date->format('d.m.Y'),
                'revision_expiration_date' => $wagon->revision_exp_date->format('d.m.Y'),
                'last_updated' => $wagon->updated_at->format('d.m.Y h:i:s')
            ]
        ]);
    }
    /**@test */
    public function testForbiddenWagonRetrieve()
    {
        $wagon = factory(Wagon::class)->create();
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->get('api/wagons/' . $wagon->id . '?api_token=' . $this->user->api_token);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testWagonsCanBeRetrieved()
    {
        factory(Wagon::class)->create();
        factory(Wagon::class)->create();

        $response = $this->get('api/wagons' . '?api_token=' . $this->user->api_token);
        $response->assertJsonCount(2, 'data');
    }
    /**@test */
    public function testForbiddenWagonsRetrieve()
    {
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->get('api/wagons' . '?api_token=' . $this->user->api_token);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testWagonCanBeUpdated()
    {
        $this->withoutExceptionHandling();
        factory(WagonType::class)->create(['name' => '22-97'])->save();
        factory(Wagon::class)->create();
        $wagon = Wagon::first();

        $response = $this->patch('api/wagons/' . $wagon->id, array_merge($this->data(), ['number' => '615222970029']));
        $wagon = Wagon::first();
        $this->assertEquals('615222970029', $wagon->number);
        $this->assertEquals('2', $wagon->type_id);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'data' => [
                'id' => $wagon->id
            ],
            'links' => [
                'self' => $wagon->path()
            ]
        ]);
    }
    /**@test */
    public function testWagonRevisionExpirationDateIsCalculated()
    {
        $this->withoutExceptionHandling();
        factory(WagonType::class)->create(['name' => '22-97', 'revision_valid_for' => 1])->save();
        $response = $this->post('api/wagons', array_merge($this->data(), ['number' => '505222970039']));
        $wagon = Wagon::first();

        $response->assertJson([
            'data' => [
                'revision_expiration_date' => $wagon->revision_exp_date->format('d.m.Y')
            ],
            'links' => [
                'self' => $wagon->path()
            ]
        ]);
    }
    /**@test */
    public function testForbiddenWagonTypeUpdate()
    {
        $wagon = factory(Wagon::class)->create();
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->patch('api/wagons/' . $wagon->id, array_merge($this->data(), ['number' => '615222970029']));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testWagonCanBeDeleted()
    {

        $wagon = factory(Wagon::class)->create();
        $this->assertCount(1, Wagon::all());

        $wagon = Wagon::first();
        $response = $this->delete('api/wagons/' . $wagon->id, ['api_token' => $this->user->api_token]);
        $this->assertCount(0, Wagon::all());
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
    /**@test */
    public function testForbiddenWagonDelete()
    {
        $wagon = factory(Wagon::class)->create();
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->delete('api/wagons/' . $wagon->id, ['api_token' => $this->user->api_token]);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    private function data()
    {
        return [
            'number' => '615285970039',
            'letter_index' => 'ARkimbz',
            'v_max' => 200,
            'seats' => 18,
            'depot_id' => 1,
            'revisory_point_id' => 1,
            'revision_date' => '2019/08/06',
            'status_id' => 1,
            'api_token' => $this->user->api_token
        ];
    }
}
