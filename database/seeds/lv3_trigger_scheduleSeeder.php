<?php

use Illuminate\Database\Seeder;

class lv3_trigger_scheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\lv3_trigger_schedule::class, 3)->create();
    }
}
