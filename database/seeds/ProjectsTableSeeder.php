<?php

use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Project::insert([
            'title' => 'Sistem Informasi Pegawawi',
            'instance_name' => 'PT. Kaya Raya',
            'client_name' => 'Andri',
            'client_phone' => '+6289123512',
            'client_email' => 'abcsd@gmail.com',
            'payment_status' => 1, //1 = belum dihitung 2 = belum dibayar, 3 = dibayar sebagian, 4 = sudah dibayar
            'project_status' => 2, //1 = gagal, 2 = pending, 3 = dikerjakan, 4 = selesai
            'user_id' => 1,
            'payment_type' => 1, // 1 = parsial, 2 = full,
            'start_date' => date('Y-m-d'),
            'finish_date' => null,
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now(),
        ]);
    }
}
