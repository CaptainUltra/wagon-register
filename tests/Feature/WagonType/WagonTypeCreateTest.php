<?php

namespace Tests\Feature\WagonType;

use App\InteriorType;
use App\WagonType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WagonTypeCreateTest extends TestCase
{
    use RefreshDatabase;
    /**@test*/
    public function testWagonTypeCanBeCreated()
    {
        $this->withoutExceptionHandling();
        $interiorType = factory(InteriorType::class)->create()->save();
        $interiorType = InteriorType::first();

        $response = $this->post('/wagontypes', [
            'name' => '22-97',
            'conditioned' => true,
            'interior_type_id' =>  $interiorType->name
        ]);
        $wagonType = WagonType::first();
        
        $response->assertOk();
        $this->assertCount(1, WagonType::all());
        $this->assertEquals(1, $wagonType->interior_type_id);
        $this->assertEquals($interiorType->name, $wagonType->interiorType->name);
    }
    /**@test */
    public function testInteriorTypeMustBeValid()
    {
        $response = $this->post('/wagontypes', [
            'name' => '22-97',
            'conditioned' => true,
            'interior_type_id' =>  'a'
        ]);

        $response->assertNotFound();
    }
    /**@test */
    public function testNameIsRequired()
    {
        $interiorType = factory(InteriorType::class)->create()->save();
        $interiorType = InteriorType::first();

        $response = $this->post('/wagontypes', [
            'name' => '',
            'conditioned' => true,
            'interior_type_id' =>  $interiorType->name
        ]);

        $response->assertSessionHasErrors('name');
    }
    /**@test */
    public function testConditionedIsRequired()
    {
        $interiorType = factory(InteriorType::class)->create()->save();
        $interiorType = InteriorType::first();

        $response = $this->post('/wagontypes', [
            'name' => '22-97',
            'conditioned' => '',
            'interior_type_id' =>  $interiorType->name
        ]);

        $response->assertSessionHasErrors('conditioned');
    }
    /**@test */
    public function testInteriorTypeIsRequired()
    {

        $response = $this->post('/wagontypes', [
            'name' => '22-97',
            'conditioned' => '',
            'interior_type_id' =>  ''
        ]);

        $response->assertSessionHasErrors('interior_type_id');
    }
}
