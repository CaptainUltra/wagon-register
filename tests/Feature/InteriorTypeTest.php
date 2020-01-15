<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\InteriorType;
use PhpParser\Node\Expr\Cast\Int_;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InteriorTypeTest extends TestCase
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
        $response = $this->post('api/interiortypes', array_merge($this->data(), ['api_token' => '']));

        $response->assertRedirect('/login');
        $this->assertCount(0, InteriorType::all());
    }
    /**@test */
    public function testInteriorTypeCanBeCreated()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('api/interiortypes', $this->data());

        $response->assertOk();
        $this->assertCount(1, InteriorType::all());
    }
    /**@test */
    public function testNameOfInteriorTypeIsRequired()
    {
        $response = $this->post('api/interiortypes', array_merge($this->data(), ['name' => '']));

        $response->assertSessionHasErrors('name');
    }
    /**@test */
    public function testInteriorTypeCanBeRetrieved()
    {
        $interiorType = factory(InteriorType::class)->create();
        $response = $this->get('api/interiortypes/' . $interiorType->id . '?api_token='.$this->user->api_token);
        $response->assertJson([
            'name' => $interiorType->name
        ]);
    }
    /**@test */
    public function testInteriorTypesCanBeRetrieved()
    {
        $interiorType = factory(InteriorType::class)->create();
        $interiorType2 = factory(InteriorType::class)->create();
        $response = $this->get('api/interiortypes/' . '?api_token='.$this->user->api_token);
        $response->assertJsonCount(2);
    }

    public function testInteriorTypeCanBeUpdated()
    {
        $this->withoutExceptionHandling();

        $this->post('api/interiortypes', $this->data());
        $interiorType = InteriorType::first();
        $response = $this->put('api/interiortypes/' . $interiorType->id, array_merge($this->data(), ['name' => 'coupe']));
        $interiorType = InteriorType::first();
        $this->assertEquals('coupe', $interiorType->name);
    }
    public function testInteriorTypeCanBeDeleted()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('api/interiortypes', $this->data());

        $this->assertCount(1, InteriorType::all());

        $interiorType = InteriorType::first();
        $this->delete('api/interiortypes/' . $interiorType->id);

        $this->assertCount(0, InteriorType::all());
    }
    private function data()
    {
        return [
            'name' => 'salon',
            'api_token' => $this->user->api_token
        ];
    }
}
