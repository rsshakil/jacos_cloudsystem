<?php

use Illuminate\Database\Seeder;

class lv3_trigger_file_pathSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\lv3_trigger_file_path::class, 3)->create();
    }
}
