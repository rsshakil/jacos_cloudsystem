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
        // factory(App\cmn_scenario::class, 3)->create();
        $scenarios = array(
            [
                'byr_buyer_id' => 1,
                'slr_seller_id' => 0,
                'class' => 'order',
                'vector' => 'to_jacos',
                'name' => 'OUK_BMS_ORDER',
                'description' => 'OUK_BMS_ORDER',
                'file_path' => 'scenarios/ouk_order_toj',
            ],
            [
                'byr_buyer_id' => 1,
                'slr_seller_id' => 0,
                'class' => 'order',
                'vector' => 'from_jacos',
                'name' => 'OUK_ORDER_VOUCHER',
                'description' => 'OUK_ORDER_VOUCHER',
                'file_path' => 'scenarios/ouk_order_voucher',
            ],
            [
                'byr_buyer_id' => 1,
                'slr_seller_id' => 0,
                'class' => 'order',
                'vector' => 'to_jacos',
                'name' => 'MASTER_ITEM_INSERTION',
                'description' => 'MASTER_ITEM_INSERTION',
                'file_path' => 'scenarios/item_master',
            ],
            [
                'byr_buyer_id' => 1,
                'slr_seller_id' => 0,
                'class' => 'order',
                'vector' => 'to_jacos',
                'name' => 'BMS_ORDER_CSV_INSERTION',
                'description' => 'BMS_ORDER_CSV_INSERTION',
                'file_path' => 'scenarios/bms_csv_order',
            ]
        );
        App\Models\CMN\cmn_scenario::insert($scenarios);
    }
}
