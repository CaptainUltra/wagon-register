<?php

namespace Tests\Feature;

use App\InteriorType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PhpParser\Node\Expr\Cast\Int_;
use Tests\TestCase;

class InteriorTypeTest extends TestCase
{
    use RefreshDatabase;
    /**@test */
    public function testInteriorTypeCanBeCreated()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/interiortypes', [
            'name' => 'salon'
        ]);

        $response->assertOk();
        $this->assertCount(1, InteriorType::all());
    }
    /**@test */
    public function testNameOfInteriorTypeIsRequired()
    {
        $response = $this->post('/interiortypes', [
            'name' => ''
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function testInteriorTypeCanBeUpdated()
    {
        $this->withoutExceptionHandling();

        $this->post('/interiortypes', [
            'name' => 'salon'
        ]);
        $interiorType = InteriorType::first();
        $response = $this->put('/interiortypes/' . $interiorType->id, [
            'name' => 'coupe'
        ]);
        $interiorType = InteriorType::first();
        $this->assertEquals('coupe', $interiorType->name);
    }
    public function testInteriorTypeCanBeDeleted()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/interiortypes', [
            'name' => 'salon'
        ]);

        $this->assertCount(1, InteriorType::all());

        $interiorType = InteriorType::first();
        $this->delete('/interiortypes/' . $interiorType->id);

        $this->assertCount(0, InteriorType::all());
    }
}
