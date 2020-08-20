<?php

use Illuminate\Database\Seeder;

class cmn_jobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\cmn_job::class, 3)->create();
    }
}
