<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\RevisoryPoint;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RevisoryPointTest extends TestCase
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
        $response = $this->post('api/revisorypoints', array_merge($this->data(), ['api_token' => '']));

        $response->assertRedirect('/login');
        $this->assertCount(0, RevisoryPoint::all());
    }
    /**@test */
    public function testRevisoryPointCanBeCreated()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('api/revisorypoints', $this->data());

        $response->assertOk();
        $this->assertCount(1, RevisoryPoint::all());
    }
    /**@test */
    public function testRequiredFields()
    {
        collect(['name', 'abbreviation'])
            ->each(function ($field) {
                $response = $this->post('api/revisorypoints', array_merge($this->data(), [$field => '']));
                $response->assertSessionHasErrors($field);
            });
    }
    /**@test */
    public function testRevisoryPointCanBeRetrieved()
    {
        $revisoryPoint = factory(RevisoryPoint::class)->create();

        $response = $this->get('api/revisorypoints/' . $revisoryPoint->id . '?api_token=' . $this->user->api_token);
        $response->assertJson([
            'name' => $revisoryPoint->name,
            'abbreviation' => $revisoryPoint->abbreviation
        ]);
    }
    /**@test */
    public function testRevisoryPointsCanBeRetrieved()
    {
        $revisoryPoint = factory(RevisoryPoint::class)->create();
        $revisoryPoint2 = factory(RevisoryPoint::class)->create();

        $response = $this->get('api/revisorypoints'.'?api_token=' . $this->user->api_token);
        $response->assertJsonCount(2);
    }

    /**@test */
    public function testRevisoryPointCanBeUpdated()
    {
        $this->withoutExceptionHandling();

        $revisoryPoint = factory(RevisoryPoint::class)->create();

        $this->patch('api/revisorypoints/' . $revisoryPoint->id, array_merge($this->data(), [
            'name' => 'Septemvri',
            'abbreviation' => 'Kwg'
        ]));
        $revisoryPoint = RevisoryPoint::first();

        $this->assertEquals('Septemvri', $revisoryPoint->name);
        $this->assertEquals('Kwg', $revisoryPoint->abbreviation);
    }
    /**@test */
    public function testRevisoryPointCanBeDeleted()
    {
        $this->withoutExceptionHandling();

        $revisoryPoint = factory(RevisoryPoint::class)->create();

        $this->assertCount(1, RevisoryPoint::all());

        $this->delete('api/revisorypoints/' . $revisoryPoint->id, ['api_token' => $this->user->api_token]);

        $this->assertCount(0, RevisoryPoint::all());
    }
    private function data()
    {
        return [
            'name' => 'Sofia',
            'abbreviation' => 'Nd',
            'api_token' => $this->user->api_token
        ];
    }
}
