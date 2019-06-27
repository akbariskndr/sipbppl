<?php

use Illuminate\Database\Seeder;

class CriteriaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Criterion::insert([
            'instance_level' => 1, // 1 - 3
            'complexity_level' => 2, // 1 - 5
            'project_id' => 1,
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now(),
        ]);
    }
}
