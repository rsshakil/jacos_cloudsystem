<?php

use Illuminate\Database\Seeder;

class cmn_scenarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\cmn_scenario::class, 3)->create();
    }
}
