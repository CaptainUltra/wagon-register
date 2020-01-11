<?php

namespace Tests\Feature;

use App\Depot;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DepotTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    /**@test */
    public function testUnAuthRedirectToLogin()
    {
        $response = $this->post('api/depots', array_merge($this->data(), ['api_token' => '']));

        $response->assertRedirect('/login');
        $this->assertCount(0, Depot::all());
    }
    /**@test */
    public function testDepotCanBeCreated()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('api/depots', $this->data());

        $response->assertOk();
        $this->assertCount(1, Depot::all());
    }
    /**@test */
    public function testNameIsRequired()
    {
        $response = $this->post('api/depots', array_merge($this->data(), ['name' => '']));
        $response->assertSessionHasErrors('name');
    }
    /**@test */
    public function testDepotCanBeRetrieved()
    {
        $depot = factory(Depot::class)->create();

        $response = $this->get('api/depots/' . $depot->id . '?api_token=' . $this->user->api_token);
        $response->assertJson([
            'name' => $depot->name
        ]);
    }
    /**@test */
    public function testDepotsCanBeRetrieved()
    {
        $depot = factory(Depot::class)->create();
        $depot2 = factory(Depot::class)->create();
        $response = $this->get('api/depots' . '?api_token=' . $this->user->api_token);
        $response->assertJsonCount(2);
        
    }
    /**@test */
    public function testDepotCanBeUpdated()
    {
        $this->withoutExceptionHandling();

        $depot = factory(Depot::class)->create();
        $this->patch('api/depots/' . $depot->id, array_merge($this->data(), ['name' => 'Septemvri']));
        $depot = Depot::first();

        $this->assertEquals('Septemvri', $depot->name);
    }
    /**@test */
    public function testDepotCanBeDeleted()
    {
        $this->withoutExceptionHandling();

        $depot = factory(Depot::class)->create();

        $this->assertCount(1, Depot::all());

        $this->delete('api/depots/' . $depot->id, ['api_token' => $this->user->api_token]);

        $this->assertCount(0, Depot::all());
    }

    private function data()
    {
        return [
            'name' => 'Sofia',
            'api_token' => $this->user->api_token
        ];
    }
}
