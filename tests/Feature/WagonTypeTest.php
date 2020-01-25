<?php

namespace Tests\Feature;

use App\User;
use App\WagonType;
use Tests\TestCase;
use App\InteriorType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Resources\Json\Resource;
use Symfony\Component\HttpFoundation\Response;

class WagonTypeTest extends TestCase
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
        $response = $this->post('api/wagontypes', array_merge($this->data(), ['api_token' => '']));

        $response->assertRedirect('/login');
        $this->assertCount(0, WagonType::all());
    }
    /**@test*/
    public function testWagonTypeCanBeCreated()
    {
        $this->withoutExceptionHandling();
        factory(InteriorType::class)->create()->save();

        $response = $this->post('api/wagontypes', $this->data());
        $wagonType = WagonType::first();

        $this->assertCount(1, WagonType::all());
        $this->assertEquals(1, $wagonType->interior_type_id);
        $this->assertEquals(1, $wagonType->interiorType->id);
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'data' => [
                'id' => $wagonType->id
            ],
            'links' => [
                'self' => $wagonType->path()
            ]
        ]);
    }
    /**@test */
    public function testInteriorTypeMustBeValid()
    {
        $response = $this->post('api/wagontypes', array_merge($this->data(), ['interior_type_id' => 2]));

        $response->assertSessionHasErrors('interior_type_id');
    }
    /**@test */
    public function testRequiredFields()
    {
        collect(['name', 'conditioned', 'interior_type_id'])
            ->each(function ($field) {
                $response = $this->post('api/wagontypes', array_merge($this->data(), [$field => '']));
                $response->assertSessionHasErrors($field);
            });
    }
    /**@test*/
    public function testWagonTypeCanBeRetrieved()
    {
        $wagonType = factory(WagonType::class)->create();

        $response = $this->get('api/wagontypes/' . $wagonType->id . '?api_token=' . $this->user->api_token);
        $response->assertJson([
            'data' => [
                'name' => $wagonType->name,
                'conditioned' => $wagonType->conditioned,
            ]
        ]);
    }
    /**@test */
    public function testWagonTypesCanBeRetrieved()
    {
        factory(WagonType::class)->create();
        factory(WagonType::class)->create();

        $response = $this->get('api/wagontypes' . '?api_token=' . $this->user->api_token);
        $response->assertJsonCount(2, 'data');
    }
    /**@test */
    public function testWagonTypeCanBeUpdated()
    {
        $this->withoutExceptionHandling();
        factory(InteriorType::class)->create()->save();
        factory(InteriorType::class)->create()->save();
        $wagonType = factory(WagonType::class)->create();

        $response = $this->put('api/wagontypes/' . $wagonType->id, array_merge($this->data(), [
            'name' => '21-50',
            'conditioned' => false,
            'interior_type_id' =>  2
        ]));
        $wagonType = WagonType::first();

        $this->assertEquals('21-50', $wagonType->name);
        $this->assertEquals(0, $wagonType->conditioned);
        $this->assertEquals(2, $wagonType->interior_type_id);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'data' => [
                'id' => $wagonType->id
            ],
            'links' => [
                'self' => $wagonType->path()
            ]
        ]);
    }
    /**@test*/
    public function testWagonTypeCanBeDeleted()
    {
        $this->withoutExceptionHandling();
        $wagonType = factory(WagonType::class)->create();

        $this->assertCount(1, WagonType::all());

        $response = $this->delete('api/wagontypes/' . $wagonType->id, ['api_token' => $this->user->api_token]);

        $this->assertCount(0, WagonType::all());
        $response->assertStatus(Response::HTTP_NO_CONTENT);

    }
    private function data()
    {
        return [
            'name' => '22-97',
            'conditioned' => true,
            'interior_type_id' =>  1,
            'api_token' => $this->user->api_token
        ];
    }
}
