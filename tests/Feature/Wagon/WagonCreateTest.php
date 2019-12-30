<?php

namespace Tests\Feature\Wagon;

use App\Wagon;
use App\WagonType;
use Tests\TestCase;
use App\InteriorType;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WagonCreateTest extends TestCase
{
    use RefreshDatabase;
    /**@test */
    public function testWagonCanBeCreated()
    {
        $this->withoutExceptionHandling();
        $interiorType = factory(InteriorType::class)->create()->save();
        $interiorType = InteriorType::first();
        $wagonType = factory(WagonType::class)->create([
            'interior_type_id' => $interiorType->name
        ])->save();

        $response = $this->post('/wagons', [
            'number' => '615285970014',
            'type_id' => ''
        ]);

        $response->assertOk();
        $this->assertCount(1, Wagon::all());
    }

    /**@test */
    public function testWagonNumberIsRequired()
    {
        $response = $this->post('/wagons', [
            'number' => '',
            'type_id' => ''
        ]);

        $response->assertSessionHasErrors('number');
    }

    /**@test */
    public function testWagonNumberMustBeUnique()
    {
        $interiorType = factory(InteriorType::class)->create()->save();
        $interiorType = InteriorType::first();
        $wagonType = factory(WagonType::class)->create([
            'interior_type_id' => $interiorType->name
        ])->save();
        $this->post('/wagons', [
            'number' => '615285970014',
            'type_id' => ''
        ]);
        $response = $this->post('/wagons', [
            'number' => '615285970014',
            'type_id' => ''
        ]);

        $response->assertSessionHasErrors('number');
    }
}
