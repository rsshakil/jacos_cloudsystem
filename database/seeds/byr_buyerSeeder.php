<?php

use Illuminate\Database\Seeder;

class byr_buyerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $byr_byr = array(
            [
                'cmn_company_id'=>1,
                'super_code'=>"OUK",
                'adm_role_id'=>1,
            ]
        );
        App\Models\BYR\byr_buyer::insert($byr_byr);
    }
}
