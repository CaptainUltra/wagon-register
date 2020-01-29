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
            ['name' => 'Test1', 'slug' => 'test-1'],
            ['name' => 'Test1', 'slug' => 'test-1']
        ];
    }
}
