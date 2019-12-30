<?php

namespace Tests\Feature;

use App\Depot;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DepotTest extends TestCase
{
    use RefreshDatabase;
    /**@test */
    public function testDepotCanBeCreated()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/depots', [
            'name' => 'Sofia'
        ]);

        $response->assertOk();
        $this->assertCount(1, Depot::all());
    }
    /**@test */
    public function testNameIsRequired()
    {
        $response = $this->post('/depots', [
            'name' => ''
        ]);
        $response->assertSessionHasErrors('name');
    }
    /**@test */
    public function testDepotCanBeUpdated()
    {
        $this->withoutExceptionHandling();

        $this->post('/depots', [
            'name' => 'Sofia'
        ]);
        $depot = Depot::first();

        $this->patch('/depots/'. $depot->id, [
            'name' => 'Septemvri'
        ]);
        $depot = Depot::first();

        $this->assertEquals('Septemvri', $depot->name);
    }
    /**@test */
    public function testDepotCanBeDeleted()
    {
        $this->withoutExceptionHandling();

        $this->post('/depots', [
            'name' => 'Sofia'
        ]);
        $depot = Depot::first();
        
        $this->assertCount(1, Depot::all());

        $this->delete('/depots/'. $depot->id);

        $this->assertCount(0, Depot::all());
    }
}
