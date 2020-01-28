<?php

namespace Tests\Feature;

use App\User;
use App\Permission;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PermissionTest extends TestCase
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
        $permission = factory(Permission::class)->create();
        $response = $this->get('api/permissions/' . $permission->id . '?api_token=');

        $response->assertRedirect('/login');
    }
    /**@test */
    public function testPermissionCanBeRetrieved()
    {
        $permission = factory(Permission::class)->create();
        $response = $this->get('api/permissions/' . $permission->id . '?api_token=' . $this->user->api_token);
        $response->assertJson([
            'data' => [
                'name' => $permission->name
            ]
        ]);
    }
    /**@test */
    public function testPermissionsCanBeRetrieved()
    {
        factory(Permission::class)->create();
        factory(Permission::class)->create();
        $response = $this->get('api/permissions' . '?api_token=' . $this->user->api_token);

        $response->assertJsonCount(2, 'data');
    }
}
