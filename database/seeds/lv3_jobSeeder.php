<?php

use Illuminate\Database\Seeder;

class lv3_jobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\lv3_job::class, 3)->create();
    }
}
