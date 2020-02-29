<?php

namespace Tests\Feature;

use App\User;
use App\Station;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StationSearchTest extends TestCase
{
    use RefreshDatabase;
    
    /**@test */
    public function testStationCanBeSearchedFor()
    {
        $user = factory(User::class)->create();
        factory(Station::class)->create(['name' => 'Aa']);
        factory(Station::class)->create();
        $response = $this->post('/api/stationsearch', ['searchTerm' => 'A', 'api_token' => $user->api_token]);
        $this->assertEquals('Aa', json_decode($response->getContent())->data[0]->data->name);
    }
}
