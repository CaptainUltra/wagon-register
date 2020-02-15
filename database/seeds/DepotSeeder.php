<?php

use App\Depot;
use Illuminate\Database\Seeder;

class DepotSeeder extends Seeder
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
            factory(Depot::class)->create(['name' => $data['name']]);
        }
    }
    /**
     * Data to be seeded
     */
    private function data()
    {
        return [
            ['name' => 'София'],
            ['name' => 'Пловдив'],
            ['name' => 'Варна'],
            ['name' => 'Горна Оряховица'],
            ['name' => 'Русе']
        ];
    }
}
