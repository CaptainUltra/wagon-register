<?php

namespace Tests\Unit;

use App\Permission;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PermissionUnitTest extends TestCase
{
    use RefreshDatabase;
    /**@test */
    public function testPermissionCanBeCreated()
    {
        $permission = factory(Permission::class)->create();
        
        $this->assertCount(1, Permission::all());
    }
}
