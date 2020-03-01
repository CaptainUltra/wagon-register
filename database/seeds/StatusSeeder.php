<?php

use App\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->data() as $data) {
            factory(Status::class)->create(['name' => $data['name']]);
        }
    }
    /**
     * Data to be seeded
     */
    private function data()
    {
        return [
            ['name' => 'В движение'],
            ['name' => 'Изтекла ревизия'],
            ['name' => 'Спрян'],
            ['name' => 'Трайно спрян'],
            ['name' => 'Бракуван'],
            ['name' => 'Нарязан'],
        ];
    }
}
