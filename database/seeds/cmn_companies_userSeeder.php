<?php

use Illuminate\Database\Seeder;

class cmn_companies_userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\cmn_companies_user::class, 3)->create();
    }
}
