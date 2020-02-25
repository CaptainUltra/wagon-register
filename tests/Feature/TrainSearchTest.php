<?php

namespace Tests\Feature;

use App\Train;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TrainSearchTest extends TestCase
{
    use RefreshDatabase;
    
    /**@test */
    public function testTrainCanBeSearchedFor()
    {
        $user = factory(User::class)->create();
        factory(Train::class)->create(['number' => '8601']);
        factory(Train::class)->create();
        $response = $this->post('/api/trainsearch', ['searchTerm' => '860', 'api_token' => $user->api_token]);
        $this->assertEquals('8601', json_decode($response->getContent())->data[0]->data->number);
    }
}
