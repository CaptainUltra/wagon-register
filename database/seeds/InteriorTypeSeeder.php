<?php

use App\InteriorType;
use Illuminate\Database\Seeder;

class InteriorTypeSeeder extends Seeder
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
            factory(InteriorType::class)->create(['name' => $data['name']]);
        }
    }
    /**
     * Data to be seeded
     */
    private function data()
    {
        return [
            ['name' => 'Безкупеен'],
            ['name' => 'Бистро'],
            ['name' => 'Купеен'],
            ['name' => 'Кушет'],
            ['name' => 'Смесен'],
            ['name' => 'Спален'],
        ];
    }
}
