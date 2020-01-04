<?php

namespace Tests\Feature\Wagon;

use App\Wagon;
use App\WagonType;
use Tests\TestCase;
use App\InteriorType;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WagonUpdateDeleteTest extends TestCase
{
    use RefreshDatabase;
    /**@test */
    public function testWagonCanBeUpdatedWithRequiredFields()
    {
        $this->withoutExceptionHandling();
        $interiorType = factory(InteriorType::class)->create()->save();
        $interiorType = InteriorType::first();
        factory(WagonType::class)->create([
            'interior_type_id' => $interiorType->name,
        ])->save();
        factory(WagonType::class)->create([
            'interior_type_id' => $interiorType->name,
            'name'=>'22-97'
        ])->save();

        $this->post('/wagons', [
            'number' => '615285970014',
        ]);
        $wagon = Wagon::first();

        $response = $this->patch('/wagons/'.$wagon->id, [
            'number' => '615222970029',
        ]);
        $wagon = Wagon::first();
        $this->assertEquals('615222970029', $wagon->number);
        $this->assertEquals('2', $wagon->type_id);
    }
    /**@test */
    public function testWagonCanBeDeleted()
    {
        $this->withoutExceptionHandling();
        $interiorType = factory(InteriorType::class)->create()->save();
        $interiorType = InteriorType::first();
        $wagonType = factory(WagonType::class)->create([
            'interior_type_id' => $interiorType->name
        ])->save();

        $this->post('/wagons', [
            'number' => '615285970014',
            'type_id' => ''
        ]);
        $this->assertCount(1, Wagon::all());

        $wagon = Wagon::first();

        $this->delete('/wagons/' . $wagon->id);
        $this->assertCount(0, Wagon::all());

    }
}
