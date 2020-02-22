<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->data() as $data)
        {
            factory(Permission::class)->create(['name' => $data['name'], 'slug' => $data['slug']]);
        }
    }
    /**
     * Data to be seeded
     */
    private function data()
    {
        return [
            ['name' => 'Depot viewAny', 'slug' => 'depot-viewAny'],
            ['name' => 'Depot view', 'slug' => 'depot-view'],
            ['name' => 'Depot create', 'slug' => 'depot-create'],
            ['name' => 'Depot update', 'slug' => 'depot-update'],
            ['name' => 'Deppt delete', 'slug' => 'depot-delete'],
            ['name' => 'Revisory point viewAny', 'slug' => 'revisorypoint-viewAny'],
            ['name' => 'Revisory point view', 'slug' => 'revisorypoint-view'],
            ['name' => 'Revisory point create', 'slug' => 'revisorypoint-create'],
            ['name' => 'Revisory point update', 'slug' => 'revisorypoint-update'],
            ['name' => 'Revisory point delete', 'slug' => 'revisorypoint-delete'],
            ['name' => 'Interior type viewAny', 'slug' => 'interiortype-viewAny'],
            ['name' => 'Interior type view', 'slug' => 'interiortype-view'],
            ['name' => 'Interior type create', 'slug' => 'interiortype-create'],
            ['name' => 'Interior type update', 'slug' => 'interiortype-update'],
            ['name' => 'Interior type delete', 'slug' => 'interiortype-delete'],
            ['name' => 'Wagon type viewAny', 'slug' => 'wagontype-viewAny'],
            ['name' => 'Wagon type view', 'slug' => 'wagontype-view'],
            ['name' => 'Wagon type create', 'slug' => 'wagontype-create'],
            ['name' => 'Wagon type update', 'slug' => 'wagontype-update'],
            ['name' => 'Wagon type delete', 'slug' => 'wagontype-delete'],
            ['name' => 'Wagon viewAny', 'slug' => 'wagon-viewAny'],
            ['name' => 'Wagon view', 'slug' => 'wagon-view'],
            ['name' => 'Wagon create', 'slug' => 'wagon-create'],
            ['name' => 'Wagon update', 'slug' => 'wagon-update'],
            ['name' => 'Wagon delete', 'slug' => 'wagon-delete'],
            ['name' => 'Train viewAny', 'slug' => 'train-viewAny'],
            ['name' => 'Train view', 'slug' => 'train-view'],
            ['name' => 'Train create', 'slug' => 'train-create'],
            ['name' => 'Train update', 'slug' => 'train-update'],
            ['name' => 'Train delete', 'slug' => 'train-delete'],
        ];
    }
}
