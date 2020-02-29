<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use App\Event;
use App\Http\Resources\Wagon as WagonResource;
use App\Wagon;
use Carbon\Carbon;
use App\Permission;
use App\WagonType;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventTest extends TestCase
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
        factory(Permission::class)->create(['slug' => 'event-viewAny']);
        factory(Permission::class)->create(['slug' => 'event-view']);
        factory(Permission::class)->create(['slug' => 'event-create']);
        factory(Permission::class)->create(['slug' => 'event-update']);
        factory(Permission::class)->create(['slug' => 'event-delete']);

        $this->user->roles[0]->permissions()->sync([1, 2, 3, 4, 5]);

        factory(WagonType::class)->create(['name' => '85-97']);
        factory(Wagon::class)->create();
    }

    /**@test */
    public function testEventUnAuthRedirectToLogin()
    {
        $response = $this->post('api/events', array_merge($this->data(), ['api_token' => '']));

        $response->assertRedirect('/login');
        $this->assertCount(0, Event::all());
    }
    /**@test */
    public function testEventCanBeCreated()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('api/events', $this->data());
        $event = Event::first();
        $this->assertCount(1, Event::all());
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'data' => [
                'id' => $event->id,
                'date' => $event->date->format('d.m.Y'),
                'comment' => $event->comment
            ],
            'links' => [
                'self' => $event->path()
            ]
        ]);
    }
    /**@test */
    public function testForbiddenEventCreate()
    {
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->post('api/events', $this->data());
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testEventRequiredFields()
    {
        collect(['date', 'wagon_id'])
            ->each(function ($field) {
                $response = $this->post('api/events', array_merge($this->data(), [$field => '']));
                $response->assertSessionHasErrors($field);
            });
    }
    /**@test */
    public function testEventStationIsReqiuiredIfThereIsNoTrain()
    {
        $response = $this->post('api/events', array_merge($this->data(), ['station_id' => '', 'train_id' => '']));
        $response->assertSessionHasErrors('station_id');
    }
    /**@test */
    public function testEventTrainIsReqiuiredIfThereIsNoStation()
    {
        $response = $this->post('api/events', array_merge($this->data(), ['station_id' => '', 'train_id' => '']));
        $response->assertSessionHasErrors('train_id');
    }
    /**@test */
    public function testEventWagonIdMustBeValid()
    {
        $response = $this->post('api/events', array_merge($this->data(), ['wagon_id' => 2]));
        $response->assertSessionHasErrors('wagon_id');
    }
    /**@test */
    public function testEventDateIsStoredProperly()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('api/events', $this->data());
        $this->assertCount(1, Event::all());
        $this->assertInstanceOf(Carbon::class, Event::first()->date);
    }
    /**@test */
    public function testEventCanBeRetrieved()
    {
        $event = factory(Event::class)->create();
        $response = $this->get('api/events/' . $event->id . '?api_token=' . $this->user->api_token);
        $response->assertJson([
            'data' => [
                'id' => $event->id,
                'date' => $event->date->format('d.m.Y'),
                'comment' => $event->comment
            ],
            'links' => [
                'self' => $event->path()
            ]
        ]);
    }
    /**@test */
    public function testForbiddenEventRetrieve()
    {
        $event = factory(Event::class)->create();
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->get('api/events/' . $event->id . '?api_token=' . $this->user->api_token);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testEventsCanBeRetrieved()
    {
        $event = factory(Event::class)->create();
        $event2 = factory(Event::class)->create();
        $response = $this->get('api/events' . '?api_token=' . $this->user->api_token);
        $response->assertJsonCount(2, 'data');
    }
    /**@test */
    public function testEventsCanBeRetrievedByUser()
    {
        factory(Event::class)->create();
        factory(Event::class)->create();
        $userId = 1;
        factory(Event::class)->create(['user_id' => $userId]);
        $response = $this->get('api/events' . '?api_token=' . $this->user->api_token . '&user_id=' . $userId);
        $response->assertJsonCount(1, 'data');
    }
    /**@test */
    public function testEventsCanBeRetrievedByWagon()
    {
        $wagonId = 1;
        factory(Event::class)->create(['wagon_id' => $wagonId]);
        factory(Event::class)->create();
        factory(Event::class)->create();
        $response = $this->get('api/events' . '?api_token=' . $this->user->api_token . '&wagon_id=' . $wagonId);
        $response->assertJsonCount(1, 'data');
    }
    /**@test */
    public function testForbiddenEventsRetrieve()
    {
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->get('api/events' . '?api_token=' . $this->user->api_token);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testEventCanBeUpdated()
    {
        $this->withoutExceptionHandling();

        $event = factory(Event::class)->create();
        $response = $this->patch('api/events/' . $event->id, array_merge($this->data(), ['comment' => 'New.']));
        $event = Event::first();

        $this->assertEquals('New.', $event->comment);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'data' => [
                'id' => $event->id,
                'date' => $event->date->format('d.m.Y'),
                'comment' => $event->comment
            ],
            'links' => [
                'self' => $event->path()
            ]
        ]);
    }
    /**@test */
    public function testForbiddenEventUpdate()
    {
        $event = factory(Event::class)->create();
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->patch('api/events/' . $event->id, array_merge($this->data(), ['name' => 'Septemvri']));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**@test */
    public function testEventCanBeDeleted()
    {
        $this->withoutExceptionHandling();

        $event = factory(Event::class)->create();

        $this->assertCount(1, Event::all());

        $response = $this->delete('api/events/' . $event->id, ['api_token' => $this->user->api_token]);

        $this->assertCount(0, Event::all());
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
    /**@test */
    public function testForbiddenEventDelete()
    {
        $event = factory(Event::class)->create();
        $this->user->roles[0]->permissions()->sync([]);
        $response = $this->delete('api/events/' . $event->id, ['api_token' => $this->user->api_token]);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    private function data()
    {
        return [
            'date' => '26.02.20',
            'comment' => 'Some comment.',
            'wagon_id' => 1,
            'station_id' => 1,
            'train_id' => 1,
            'api_token' => $this->user->api_token
        ];
    }
}
