<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(InteriorTypeSeeder::class);
        $this->call(WagonTypeSeeder::class);
        $this->call(DepotSeeder::class);
        $this->call(RevisoryPointSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(StationSeeder::class);
    }
}
