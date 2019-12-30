<?php

namespace Tests\Feature;

use App\RevisoryPoint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RevisoryPointTest extends TestCase
{
    use RefreshDatabase;
    /**@test */
    public function testRevisoryPointCanBeCreated()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/revisorypoints', [
            'name' => 'Sofia',
            'abbreviation' => 'Nd'
        ]);

        $response->assertOk();
        $this->assertCount(1, RevisoryPoint::all());
    }
    /**@test */
    public function testNameIsRequired()
    {
        $response = $this->post('/revisorypoints', [
            'name' => '',
            'abbreviation' => 'Nd'
        ]);
        $response->assertSessionHasErrors('name');
    }
    /**@test */
    public function testAbbreviationIsRequired()
    {
        $response = $this->post('/revisorypoints', [
            'name' => 'Sofia',
            'abbreviation' => ''
        ]);
        $response->assertSessionHasErrors('abbreviation');
    }
    /**@test */
    public function testRevisoryPointCanBeUpdated()
    {
        $this->withoutExceptionHandling();

        $this->post('/revisorypoints', [
            'name' => 'Sofia',
            'abbreviation' => 'Nd'
        ]);
        $revisoryPoint = RevisoryPoint::first();

        $this->patch('/revisorypoints/'. $revisoryPoint->id, [
            'name' => 'Septemvri',
            'abbreviation' => 'Kwg'
        ]);
        $revisoryPoint = RevisoryPoint::first();

        $this->assertEquals('Septemvri', $revisoryPoint->name);
        $this->assertEquals('Kwg', $revisoryPoint->abbreviation);
    }
    /**@test */
    public function testRevisoryPointCanBeDeleted()
    {
        $this->withoutExceptionHandling();

        $this->post('/revisorypoints', [
            'name' => 'Sofia',
            'abbreviation' => 'Nd'
        ]);
        $revisoryPoint = RevisoryPoint::first();
        
        $this->assertCount(1, RevisoryPoint::all());

        $this->delete('/revisorypoints/'. $revisoryPoint->id);

        $this->assertCount(0, RevisoryPoint::all());
    }
}
