<?php

use Illuminate\Database\Seeder;

class CostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $project = App\Project::find(1);
        $criterion = $project->criterion;
        $features = $project->features;
        $weight = App\Weight::latest()->first();
        App\Cost::insert([
            'calculation_result' 
        ]);
    }
}
