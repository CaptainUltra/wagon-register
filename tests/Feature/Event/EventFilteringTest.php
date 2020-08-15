<?php

namespace Tests\Feature\Event;

use App\Role;
use App\User;
use App\Event;
use App\Permission;
use App\Wagon;
use App\WagonType;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventFilteringTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();

        $role = factory(Role::class)->create();
        $this->user->roles()->sync($role);
        factory(Permission::class)->create(['slug' => 'event-viewAny']);
        $this->user->roles[0]->permissions()->sync(1);

        factory(WagonType::class)->create(['name' => '85-97', 'revision_valid_for' => 1]);
        factory(Wagon::class)->create();
        factory(Wagon::class)->create();
    }

    /**
     * Test events can be filtered by wagon id.
     *
     * @return void
     */
    public function testEventsCanBeFilteredByWagonId()
    {
        factory(Event::class)->create(['wagon_id' => 1]);
        factory(Event::class)->create(['wagon_id' => 2]);

        $response = $this->get('api/events' . '?wagon_id=1' . '&api_token=' . $this->user->api_token);
        $response->assertJsonCount(1, 'data');
    }

    /**
     * Test events can be filtered by train id.
     *
     * @return void
     */
    public function testEventsCanBeFilteredByTrainId()
    {
        factory(Event::class)->create(['train_id' => 1, 'wagon_id' => 1]);
        factory(Event::class)->create(['train_id' => 2, 'wagon_id' => 1]);

        $response = $this->get('api/events' . '?train_id=1' . '&api_token=' . $this->user->api_token);
        $response->assertJsonCount(1, 'data');
    }

    /**
     * Test events can be filtered by date.
     *
     * @return void
     */
    public function testEventsCanBeFilteredByDate()
    {
        factory(Event::class)->create(['date' => '2020-08-14', 'wagon_id' => 1]);
        factory(Event::class)->create(['date' => '2020-08-13', 'wagon_id' => 1]);

        $response = $this->get('api/events' . '?date=2020-08-13' . '&api_token=' . $this->user->api_token);
        $response->assertJsonCount(1, 'data');
    }

    /**
     * Test events can be filtered by created_at.
     *
     * @return void
     */
    public function testEventsCanBeFilteredByCreatedAt()
    {
        factory(Event::class)->create(['created_at' => '2020-08-14', 'wagon_id' => 1]);
        factory(Event::class)->create(['created_at' => '2020-08-13', 'wagon_id' => 1]);

        $response = $this->get('api/events' . '?created_at=2020-08-13' . '&api_token=' . $this->user->api_token);
        $response->assertJsonCount(1, 'data');
    }

    /**
     * Test events can be filtered by station id.
     *
     * @return void
     */
    public function testEventsCanBeFilteredByStationId()
    {
        factory(Event::class)->create(['station_id' => 1, 'wagon_id' => 1]);
        factory(Event::class)->create(['station_id' => 2, 'wagon_id' => 1]);

        $response = $this->get('api/events' . '?station_id=1' . '&api_token=' . $this->user->api_token);
        $response->assertJsonCount(1, 'data');
    }

    /**
     * Test events can be filtered by user id.
     *
     * @return void
     */
    public function testEventsCanBeFilteredByUserId()
    {
        factory(Event::class)->create(['user_id' => 1, 'wagon_id' => 1]);
        factory(Event::class)->create(['user_id' => 2, 'wagon_id' => 1]);

        $response = $this->get('api/events' . '?user_id=1' . '&api_token=' . $this->user->api_token);
        $response->assertJsonCount(1, 'data');
    }
}
