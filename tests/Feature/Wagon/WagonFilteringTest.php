<?php

namespace Tests\Feature\Wagon;

use App\Role;
use App\User;
use App\Depot;
use App\Wagon;
use App\WagonType;
use App\RevisoryPoint;
use App\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WagonFilteringTest extends TestCase
{
    use RefreshDatabase;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        factory(WagonType::class)->create(['name' => '85-97', 'revision_valid_for' => 1]);
        factory(Depot::class)->create();
        factory(RevisoryPoint::class)->create();

        $role = factory(Role::class)->create();
        $this->user->roles()->sync($role);
        factory(Permission::class)->create(['slug' => 'wagon-viewAny']);
        $this->user->roles[0]->permissions()->sync(1);
    }

    /**@test */
    public function testWagonsCanBeFilteredByStatusId()
    {
        factory(Wagon::class)->create(['status_id' => 1]);
        factory(Wagon::class)->create(['status_id' => 2]);

        $response = $this->get('api/wagons' . '?status=1' . '&api_token=' . $this->user->api_token);
        $response->assertJsonCount(1, 'data');
    }
    /**@test */
    public function testWagonResultsSorting()
    {
        $wagon1 = factory(Wagon::class)->create(['number' => '615285970019']);
        $wagon2 = factory(Wagon::class)->create(['number' => '615285970039']);

        //Test ascending
        $responseAsc = $this->get('api/wagons' . '?sort=asc' . '&api_token=' . $this->user->api_token);
        $this->assertEquals($wagon1->number, $responseAsc->getData()->data[0]->data->number);

        //Test descending
        $responseDesc = $this->get('api/wagons' . '?sort=desc' . '&api_token=' . $this->user->api_token);
        $this->assertEquals($wagon2->number, $responseDesc->getData()->data[0]->data->number);
    }
    /**@test */
    public function testWagonsCanBeFilteredByWagonTypeId()
    {
        factory(Wagon::class)->create(['number' => '615285970039']);
        factory(WagonType::class)->create(['name' => '22-97']);
        $wagon = factory(Wagon::class)->create(['number' => '615222970039']);

        $response = $this->get('api/wagons' . '?wagon_type=2' . '&api_token=' . $this->user->api_token);

        $this->assertEquals($wagon->type_id, $response->getData()->data[0]->data->type->data->id);
    }
    /**@test */
    public function testWagonsCanBeFilteredByRevisoryPointId()
    {
        factory(Wagon::class)->create(['revisory_point_id' => 1]);
        factory(Wagon::class)->create(['revisory_point_id' => 2]);

        $response = $this->get('api/wagons' . '?revisory_point=1' . '&api_token=' . $this->user->api_token);
        $response->assertJsonCount(1, 'data');
    }
    /**@test */
    public function testWagonsCanBeFilteredByDepotId()
    {
        factory(Wagon::class)->create(['depot_id' => 1]);
        factory(Wagon::class)->create(['depot_id' => 2]);

        $response = $this->get('api/wagons' . '?depot=1' . '&api_token=' . $this->user->api_token);
        $response->assertJsonCount(1, 'data');
    }
    /**@test */
    public function testWagonsCanBeFilteredByRevisionDate()
    {
        factory(Wagon::class)->create(['revision_date' => "2020-06-19"]);
        factory(Wagon::class)->create(['revision_date' => "2020-05-19"]);

        $response = $this->get('api/wagons' . '?revision_date=2020-06-19' . '&api_token=' . $this->user->api_token);
        $response->assertJsonCount(1, 'data');
    }
    /**@test */
    public function testWagonsCanBeFilteredByRevisionExpiringThisMonth()
    {
        factory(Wagon::class)->create(['revision_date' => "2019-01-09"]);
        factory(Wagon::class)->create(['revision_date' => "2019-" . date("m") ."-09"]);

        $response = $this->get('api/wagons' . '?revision_expiration_this_month=1' . '&api_token=' . $this->user->api_token);
        $response->assertJsonCount(1, 'data');
    }
}
