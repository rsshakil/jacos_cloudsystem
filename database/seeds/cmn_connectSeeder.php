<?php

use Illuminate\Database\Seeder;

class cmn_connectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $cmn_connect = array(
            [
                'byr_buyer_id'=>1,
                'byr_shop_id'=>0,
                'slr_seller_id'=>1,
                'slr_ware_house_id'=>0,
                'partner_code'=>'010690',
                'is_active'=>1,
            ],[
                'byr_buyer_id'=>1,
                'byr_shop_id'=>0,
                'slr_seller_id'=>2,
                'slr_ware_house_id'=>0,
                'partner_code'=>'010540',
                'is_active'=>1,
            ],[
                'byr_buyer_id'=>1,
                'byr_shop_id'=>0,
                'slr_seller_id'=>3,
                'slr_ware_house_id'=>0,
                'partner_code'=>'011980',
                'is_active'=>1,
            ],[
                'byr_buyer_id'=>1,
                'byr_shop_id'=>0,
                'slr_seller_id'=>4,
                'slr_ware_house_id'=>0,
                'partner_code'=>'012060',
                'is_active'=>1,
            ]
        );
        App\Models\CMN\cmn_connect::insert($cmn_connect);
    }
}
