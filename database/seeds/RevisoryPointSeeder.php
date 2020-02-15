<?php

use App\RevisoryPoint;
use Illuminate\Database\Seeder;

class RevisoryPointSeeder extends Seeder
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
            factory(RevisoryPoint::class)->create(['name' => $data['name'], 'abbreviation' => $data['abbreviation']]);
        }
    }
    /**
     * Data to be seeded
     */
    private function data()
    {
        return [
            ['name' => 'Надежда', 'abbreviation' => 'Nd'],
            ['name' => 'Септември', 'abbreviation' => 'Kwg'],
            ['name' => 'Горна Оряховица', 'abbreviation' => 'Go'],
            ['name' => 'Дряново', 'abbreviation' => 'Dv'],
            ['name' => 'Хан Крум', 'abbreviation' => 'HCR'],
            ['name' => 'Пловдив', 'abbreviation' => 'Po'],
            ['name' => 'Левски', 'abbreviation' => 'L'],
            ['name' => 'Септември', 'abbreviation' => 'Sp'],
        ];
    }
}
