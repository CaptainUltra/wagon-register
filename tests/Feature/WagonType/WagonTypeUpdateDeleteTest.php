<?php

namespace Tests\Feature\WagonType;

use App\InteriorType;
use App\WagonType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WagonTypeUpdateDeleteTest extends TestCase
{
    use RefreshDatabase;
    /**@test*/
    public function testWagonTypeCanBeUpdated()
    {
        $this->withoutExceptionHandling();
        $interiorType = factory(InteriorType::class)->create()->save();
        $interiorType = InteriorType::first();

        $this->post('/wagontypes', [
            'name' => '22-97',
            'conditioned' => true,
            'interior_type_id' =>  $interiorType->name
        ]);
        $wagonType = WagonType::first();

        $this->put('/wagontypes/' . $wagonType->id, [
            'name' => '21-50',
            'conditioned' => false,
            'interior_type_id' =>  $interiorType->name
        ]);
        $wagonType = WagonType::first();

        $this->assertEquals('21-50', $wagonType->name);
        $this->assertEquals(0, $wagonType->conditioned);
    }
    /**@test*/
    public function testWagonTypeCanBeDeleted()
    {
        $this->withoutExceptionHandling();
        $interiorType = factory(InteriorType::class)->create()->save();
        $interiorType = InteriorType::first();

        $this->post('/wagontypes', [
            'name' => '22-97',
            'conditioned' => true,
            'interior_type_id' =>  $interiorType->name
        ]);
        $wagonType = WagonType::first();
        
        $this->assertCount(1, WagonType::all());

        $this->delete('/wagontypes/' . $wagonType->id);

        $this->assertCount(0, WagonType::all());
    }
}
