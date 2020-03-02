<?php

use App\Station;
use Illuminate\Database\Seeder;

class StationSeeder extends Seeder
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
            factory(Station::class)->create(['name' => $data['name']]);
        }
    }
    /**
     * Data to be seeded
     */
    private function data()
    {
        return [
            ['name' => 'Левски'],
            ['name' => 'Бургас'],
            ['name' => 'Варна'],
            ['name' => 'Враца'],
            ['name' => 'Горна Оряховица'],
            ['name' => 'Димитровград'],
            ['name' => 'Дупница'],
            ['name' => 'Карлово'],
            ['name' => 'Карнобат'],
            ['name' => 'Мездрa'],
            ['name' => 'Пазарджик'],
            ['name' => 'Плевен'],
            ['name' => 'Пловдив'],
            ['name' => 'Русе'],
            ['name' => 'Свиленград'],
            ['name' => 'Септември'],
            ['name' => 'София'],
            ['name' => 'Стара Загора'],
            ['name' => 'Шумен'],
            ['name' => 'Ямбол'],
        ];
    }
}
