<?php

namespace Tests\Feature\Wagon;

use App\Role;
use App\User;
use App\Depot;
use App\WagonType;
use App\Permission;
use Tests\TestCase;
use App\RevisoryPoint;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WagonValidationRulesTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        factory(WagonType::class)->create(['name' => '85-97']);
        factory(Depot::class)->create();
        factory(RevisoryPoint::class)->create();

        $role = factory(Role::class)->create();
        $this->user->roles()->sync($role);
        factory(Permission::class)->create(['slug' => 'wagon-viewAny']);
        factory(Permission::class)->create(['slug' => 'wagon-view']);
        factory(Permission::class)->create(['slug' => 'wagon-create']);
        factory(Permission::class)->create(['slug' => 'wagon-update']);
        factory(Permission::class)->create(['slug' => 'wagon-delete']);
        $this->user->roles[0]->permissions()->sync([1, 2, 3, 4, 5]);
    }

    /**
     * Test RegEx that validates only-number string for wagon number.
     *
     * @return void
     */
    public function testWagonNumberMustBeOnlyDigits()
    {
        //Digits + space
        $response = $this->post('api/wagons', array_merge($this->data(), ['number' => '61 285970039']));
        $response->assertSessionHasErrors('number');

        //Digits + letter
        $response = $this->post('api/wagons', array_merge($this->data(), ['number' => '61a285970039']));
        $response->assertSessionHasErrors('number');

        //Only letters
        $response = $this->post('api/wagons', array_merge($this->data(), ['number' => 'aaaaaaaaaaaa']));
        $response->assertSessionHasErrors('number');
    }

    /**
     * Test wagon number is required to be exactly 12 digits.
     * 
     * @return void
     */
    public function testWagonNumberMustBe12Digits()
    {
        //More digits
        $response = $this->post('api/wagons', array_merge($this->data(), ['number' => '6152859700391']));
        $response->assertSessionHasErrors('number');

        //Less digits
        $response = $this->post('api/wagons', array_merge($this->data(), ['number' => '6152859700391']));
        $response->assertSessionHasErrors('number');
    }

    /**
     * Test wagon number must be unique.
     * 
     * @return void
     */
    public function testWagonNumberMustBeUnique()
    {
        $this->fail('(WIP) Incomplete test.');
    }

    /**
     * Fuction to return test data.abs
     * 
     * @return mixed
     */
    private function data()
    {
        return [
            'number' => '615285970039',
            'letter_index' => 'ARkimbz',
            'v_max' => 200,
            'seats' => 18,
            'depot_id' => 1,
            'revisory_point_id' => 1,
            'revision_date' => '2019/08/06',
            'status_id' => 1,
            'api_token' => $this->user->api_token
        ];
    }
}
