<?php

use Illuminate\Database\Seeder;

class WeightsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Weight::insert([
            'complexity_weight' => 10.5,
            'features_weight' => 2.5,
            'base_small' => 2000000,
            'base_medium' => 5000000,
            'base_big' => 10000000,
            'user_id' => 1,
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now(),
        ]);
    }
}
