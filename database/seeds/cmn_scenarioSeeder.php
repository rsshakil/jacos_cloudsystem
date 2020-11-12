<?php

use Illuminate\Database\Seeder;
use App\Models\CMN\cmn_scenario;

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
                'adm_role_id' => 5,
                'class' => 'order',
                'vector' => 'to_jacos',
                'name' => 'OUK_BMS_ORDER',
                'description' => 'OUK_BMS_ORDER',
                'file_path' => 'scenarios/ouk_order_toj',
            ],
            [
                'byr_buyer_id' => 1,
                'slr_seller_id' => 0,
                'adm_role_id' => 4,
                'class' => 'order',
                'vector' => 'from_jacos',
                'name' => 'OUK_ORDER_VOUCHER',
                'description' => 'OUK_ORDER_VOUCHER',
                'file_path' => 'scenarios/ouk_order_voucher',
            ],
            [
                'byr_buyer_id' => 1,
                'slr_seller_id' => 0,
                'adm_role_id' => 5,
                'class' => 'order',
                'vector' => 'to_jacos',
                'name' => 'MASTER_ITEM_INSERTION',
                'description' => 'MASTER_ITEM_INSERTION',
                'file_path' => 'scenarios/item_master',
            ],
            [
                'byr_buyer_id' => 1,
                'slr_seller_id' => 0,
                'adm_role_id' => 5,
                'class' => 'order',
                'vector' => 'to_jacos',
                'name' => 'BMS_ORDER_CSV_INSERTION',
                'description' => 'BMS_ORDER_CSV_INSERTION',
                'file_path' => 'scenarios/bms_csv_order',
            ],
            [
                'byr_buyer_id' => 1,
                'slr_seller_id' => 0,
                'adm_role_id' => 4,
                'class' => 'order',
                'vector' => 'to_jacos',
                'name' => 'JOB_SCHEDULE',
                'description' => 'JOB_SCHEDULE',
                'file_path' => 'scenarios/schedule_data',
            ],
            [
                'byr_buyer_id' => 1,
                'slr_seller_id' => 0,
                'adm_role_id' => 4,
                'class' => 'shipment',
                'vector' => 'from_jacos',
                'name' => 'SHIPMENT CSV GENERATE',
                'description' => 'SHIPMENT CSV GENERATE',
                'file_path' => 'scenarios/shipment_csv_generate',
            ],
            [
                'byr_buyer_id' => 1,
                'slr_seller_id' => 0,
                'adm_role_id' => 4,
                'class' => 'order',
                'vector' => 'to_jacos',
                'name' => 'ORDER FIXED LENGT GENERATE',
                'description' => 'BMS ORDER FIXED LENGT GENERATE',
                'file_path' => 'scenarios/fixed_length_generate',
            ],
            [
                'byr_buyer_id' => 1,
                'slr_seller_id' => 0,
                'adm_role_id' => 4,
                'class' => 'order',
                'vector' => 'in_jacos',
                'name' => 'ORDER FILE DELETE',
                'description' => 'BMS ORDER ORDER FILE DELETE',
                'file_path' => 'scenarios/file_delete_scenario',
            ],
            [
                'byr_buyer_id' => 1,
                'slr_seller_id' => 0,
                'adm_role_id' => 4,
                'class' => 'order',
                'vector' => 'in_jacos',
                'name' => 'BYR ORDER INDEPEN FIXED LENGTH GENERATE',
                'description' => 'BYR ORDER INDEPEN FIXED LENGTH GENERATE',
                'file_path' => 'scenarios/indepen_fixed_length_generate',
            ],
            [
                'byr_buyer_id' => 1,
                'slr_seller_id' => 0,
                'adm_role_id' => 4,
                'class' => 'order',
                'vector' => 'in_jacos',
                'name' => 'BYR ORDER INDEPEN CSV GENERATE',
                'description' => 'BYR ORDER INDEPEN CSV GENERATE',
                'file_path' => 'scenarios/indepen_csv_generate',
            ],
        );
        cmn_scenario::insert($scenarios);
    }
}
