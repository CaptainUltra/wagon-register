<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleUser = factory(App\Role::class)->create(['name' => 'User role', 'slug' => 'user-role']);
        $roleUser->permissions()->sync([1, 2, 6, 7, 11, 12, 16, 17, 21, 22, 26, 27, 31, 32, 36, 37, 38]);
        $roleUser->save();
        $roleModerator = factory(App\Role::class)->create(['name' => 'Moderator role', 'slug' => 'moderator-role']);
        $roleModerator->permissions()->sync([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40]);
        $roleModerator->save();
    }
}
