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
        $roleUser = factory(App\Role::class)->create(['name' => 'Потребител', 'slug' => 'user-role']);
        $roleUser->permissions()->sync([1, 6, 16, 21, 22, 26, 27, 31, 32, 42]);
        $roleUser->save();
        $roleTrustedUser = factory(App\Role::class)->create(['name' => 'Доверен потребител', 'slug' => 'trusted-user-role']);
        $roleTrustedUser->permissions()->sync([1, 6, 16, 21, 22, 26, 27, 31, 32, 36, 37, 38, 42]);
        $roleTrustedUser->save();
        $roleModerator = factory(App\Role::class)->create(['name' => 'Модератор', 'slug' => 'moderator-role']);
        $roleModerator->permissions()->sync([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48]);
        $roleModerator->save();
        $roleAdministrator = factory(App\Role::class)->create(['name' => 'Администратор', 'slug' => 'administrator-role']);
        $roleAdministrator->permissions()->sync([49, 50, 51, 52, 53, 54, 55, 56, 57, 58]);
        $roleAdministrator->save();
    }
}
