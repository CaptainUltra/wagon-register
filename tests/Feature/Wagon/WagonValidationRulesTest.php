<?php

namespace Tests\Feature\Wagon;

use App\Role;
use App\User;
use App\Depot;
use App\Wagon;
use App\Status;
use App\WagonType;
use App\Permission;
use Tests\TestCase;
use App\RevisoryPoint;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
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
        factory(Status::class)->create();

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
        factory(Wagon::class)->create(['number' => '615285970039']);

        $response = $this->post('api/wagons', array_merge($this->data(), ['number' => '615285970039']));
        $response->assertSessionHasErrors('number');
    }

    /**
     * Test wagon v_max must be an interger validation.
     * 
     * @return void
     */
    public function testWagonVMaxMustBeAnInteger()
    {
        //Decmal number with point
        $response = $this->post('api/wagons', array_merge($this->data(), ['v_max' => '9.35']));
        $response->assertSessionHasErrors('v_max');

        //Decmal number with comma
        $response = $this->post('api/wagons', array_merge($this->data(), ['v_max' => '9,35']));
        $response->assertSessionHasErrors('v_max');

        //Letters
        $response = $this->post('api/wagons', array_merge($this->data(), ['v_max' => 'aaa']));
        $response->assertSessionHasErrors('v_max');
    }

    /**
     * Test wagon seats count must be an interger validation.
     * 
     * @return void
     */
    public function testWagonSeatsMustBeAnInteger()
    {
        //Decmal number with point
        $response = $this->post('api/wagons', array_merge($this->data(), ['seats' => '9.35']));
        $response->assertSessionHasErrors('seats');

        //Decmal number with comma
        $response = $this->post('api/wagons', array_merge($this->data(), ['seats' => '9,35']));
        $response->assertSessionHasErrors('seats');

        //Letters
        $response = $this->post('api/wagons', array_merge($this->data(), ['seats' => 'aaa']));
        $response->assertSessionHasErrors('seats');
    }

    /**
     * Test that wagon revision_date must be a date.
     * 
     * @return void
     */
    public function testWagonRevisionDateMustBeADate()
    {
        //Number
        $response = $this->post('api/wagons', array_merge($this->data(), ['revision_date' => '9']));
        $response->assertSessionHasErrors('revision_date');

        //Letters
        $response = $this->post('api/wagons', array_merge($this->data(), ['revision_date' => 'aaa']));
        $response->assertSessionHasErrors('revision_date');
    }

    /**
     * Test that wagon depot_id must exist in database.
     * 
     * @return void
     */
    public function testWagonDepotIdMustExist()
    {
        $response = $this->post('api/wagons', array_merge($this->data(), ['depot_id' => 2]));
        $response->assertSessionHasErrors('depot_id');
    }

    /**
     * Test that wagon revisory_point_id must exist in database.
     * 
     * @return void
     */
    public function testWagonRevisoryPointIdMustExist()
    {
        $response = $this->post('api/wagons', array_merge($this->data(), ['revisory_point_id' => 2]));
        $response->assertSessionHasErrors('revisory_point_id');
    }

    /**
     * Test that wagon status_id must exist in database.
     * 
     * @return void
     */
    public function testWagonStatusIdMustExist()
    {
        $response = $this->post('api/wagons', array_merge($this->data(), ['status_id' => 2]));
        $response->assertSessionHasErrors('status_id');
    }

    /**
     * Test that wagon fields with sometimes validation can be null.
     * (v_max, seats, depot_id, revisory_point_id, revision_date, status_id)
     * 
     * @return void
     */
    public function testWagonFieldsCanBeNull()
    {
        $response = $this->post('api/wagons', array_merge($this->data(), [
            'v_max' => null,
            'seats' => null,
            'depot_id' => null,
            'revisory_point_id' => null,
            'revision_date' => null,
            'status_id' => null
        ]));

        //Satus code will be different if the data is invalid.
        $response->assertStatus(Response::HTTP_CREATED);
    }

    /**
     * Test wagon can be updated without changing its number. (Unique validation for number is ignored)
     * 
     * @return void
     */
    public function testWagonCanBeUpdatedWithSameNumber()
    {
        factory(Wagon::class)->create();
        $wagon = Wagon::first();

        $response = $this->patch('api/wagons/' . $wagon->id, $this->data());
        $wagon = Wagon::first();

        $this->assertEquals('615285970039', $wagon->number);
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Fuction to return test data.
     * 
     * @return array
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
