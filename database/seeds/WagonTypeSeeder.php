<?php

use App\WagonType;
use Illuminate\Database\Seeder;

class WagonTypeSeeder extends Seeder
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
            factory(WagonType::class)->create(['name' => $data['name'], 'conditioned' => $data['conditioned'], 'revision_valid_for' => $data['revision_valid_for'], 'interior_type_id' => $data['interior_type_id']]);
        }
    }
    /**
     * Data to be seeded
     */
    private function data()
    {
        return [
            ['name' => '21-33', 'conditioned' => false, 'revision_valid_for' => 5, 'interior_type_id' => 1],
            ['name' => '21-43', 'conditioned' => false, 'revision_valid_for' => 5, 'interior_type_id' => 1],
            ['name' => '21-45', 'conditioned' => false, 'revision_valid_for' => 5, 'interior_type_id' => 1],
            ['name' => '20-47', 'conditioned' => false, 'revision_valid_for' => 2, 'interior_type_id' => 3],
            ['name' => '20-44', 'conditioned' => true, 'revision_valid_for' => 5, 'interior_type_id' => 1],
            ['name' => '84-44', 'conditioned' => true, 'revision_valid_for' => 5, 'interior_type_id' => 1],
            ['name' => '25-63', 'conditioned' => true, 'revision_valid_for' => 5, 'interior_type_id' => 1],
            ['name' => '15-63', 'conditioned' => true, 'revision_valid_for' => 5, 'interior_type_id' => 1],
            ['name' => '31-43', 'conditioned' => false, 'revision_valid_for' => 5, 'interior_type_id' => 1],
            ['name' => '22-97', 'conditioned' => false, 'revision_valid_for' => 4, 'interior_type_id' => 5],
            ['name' => '21-50', 'conditioned' => false, 'revision_valid_for' => 4, 'interior_type_id' => 3],
            ['name' => '29-74', 'conditioned' => false, 'revision_valid_for' => 4, 'interior_type_id' => 3],
            ['name' => '27-47', 'conditioned' => false, 'revision_valid_for' => 2, 'interior_type_id' => 1],
            ['name' => '19-40', 'conditioned' => false, 'revision_valid_for' => 2, 'interior_type_id' => 3],
            ['name' => '19-74', 'conditioned' => false, 'revision_valid_for' => 4, 'interior_type_id' => 3],
            ['name' => '10-50', 'conditioned' => false, 'revision_valid_for' => 4, 'interior_type_id' => 3],
            ['name' => '85-97', 'conditioned' => true, 'revision_valid_for' => 1, 'interior_type_id' => 2],
            ['name' => '20-40', 'conditioned' => false, 'revision_valid_for' => 2, 'interior_type_id' => 3],
            ['name' => '70-71', 'conditioned' => true, 'revision_valid_for' => 1, 'interior_type_id' => 6],
            ['name' => '10-47', 'conditioned' => false, 'revision_valid_for' => 2, 'interior_type_id' => 3],
            ['name' => '20-17', 'conditioned' => false, 'revision_valid_for' => 2, 'interior_type_id' => 1],
            ['name' => '50-80', 'conditioned' => false, 'revision_valid_for' => 1, 'interior_type_id' => 4],

        ];
    }
}
