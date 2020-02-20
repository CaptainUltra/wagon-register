<?php

namespace Tests\Feature;

use App\User;
use App\Wagon;
use App\WagonType;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WagonSearchTest extends TestCase
{
    use RefreshDatabase;
    /**@test */
    public function testWagonCanBeSearchedFor()
    {
        $user = factory(User::class)->create();
        factory(WagonType::class)->create(['name' => '85-97']);
        factory(WagonType::class)->create(['name' => '22-97']);
        factory(Wagon::class)->create(['number' => '615285970015']);
        factory(Wagon::class)->create(['number' => '615222970015']);
        factory(Wagon::class)->create();
        $response = $this->post('/api/wagonsearch', ['searchTerm' => '85-97 001', 'api_token' => $user->api_token]);
        $this->assertEquals('615285970015', json_decode($response->getContent())->data[0]->data->number);
    }
}
