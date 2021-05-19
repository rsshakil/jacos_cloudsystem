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
                'file_path' => 'Scenarios/ouk_order_toj',
            ],
            [
                'byr_buyer_id' => 1,
                'slr_seller_id' => 0,
                'adm_role_id' => 4,
                'class' => 'order',
                'vector' => 'from_jacos',
                'name' => 'OUK_ORDER_VOUCHER',
                'description' => 'OUK_ORDER_VOUCHER',
                'file_path' => 'Scenarios/ouk_order_voucher',
            ],
            [
                'byr_buyer_id' => 1,
                'slr_seller_id' => 0,
                'adm_role_id' => 5,
                'class' => 'order',
                'vector' => 'to_jacos',
                'name' => 'MASTER_ITEM_INSERTION',
                'description' => 'MASTER_ITEM_INSERTION',
                'file_path' => 'Scenarios/item_master',
            ],
            [
                'byr_buyer_id' => 1,
                'slr_seller_id' => 0,
                'adm_role_id' => 5,
                'class' => 'order',
                'vector' => 'to_jacos',
                'name' => 'DATA_ORDER_CSV_INSERTION',
                'description' => 'DATA_ORDER_CSV_INSERTION',
                'file_path' => 'Scenarios/byr/OUK/data_csv_order',
            ],
            [
                'byr_buyer_id' => 1,
                'slr_seller_id' => 0,
                'adm_role_id' => 4,
                'class' => 'order',
                'vector' => 'to_jacos',
                'name' => 'JOB_SCHEDULE',
                'description' => 'JOB_SCHEDULE',
                'file_path' => 'Scenarios/schedule_data',
            ],
            [
                'byr_buyer_id' => 1,
                'slr_seller_id' => 0,
                'adm_role_id' => 4,
                'class' => 'order',
                'vector' => 'to_jacos',
                'name' => 'ORDER FIXED LENGT GENERATE',
                'description' => 'BMS ORDER FIXED LENGT GENERATE',
                'file_path' => 'Scenarios/byr/OUK/fixed_length_generate',
            ],
            [
                'byr_buyer_id' => 1,
                'slr_seller_id' => 0,
                'adm_role_id' => 4,
                'class' => 'order',
                'vector' => 'in_jacos',
                'name' => 'ORDER FILE DELETE',
                'description' => 'BMS ORDER ORDER FILE DELETE',
                'file_path' => 'Scenarios/file_delete_scenario',
            ],
            [
                'byr_buyer_id' => 1,
                'slr_seller_id' => 0,
                'adm_role_id' => 4,
                'class' => 'order',
                'vector' => 'in_jacos',
                'name' => 'BYR ORDER INDEPEN FIXED LENGTH GENERATE',
                'description' => 'BYR ORDER INDEPEN FIXED LENGTH GENERATE',
                'file_path' => 'Scenarios/indepen_fixed_length_generate',
            ],
            [
                'byr_buyer_id' => 1,
                'slr_seller_id' => 0,
                'adm_role_id' => 4,
                'class' => 'order',
                'vector' => 'in_jacos',
                'name' => 'BYR ORDER INDEPEN CSV GENERATE',
                'description' => 'BYR ORDER INDEPEN CSV GENERATE',
                'file_path' => 'Scenarios/indepen_csv_generate',
            ],
            [
                'byr_buyer_id' => 1,
                'slr_seller_id' => 0,
                'adm_role_id' => 4,
                'class' => 'order',
                'vector' => 'in_jacos',
                'name' => 'order data for download',
                'description' => 'order data for download',
                'file_path' => 'Scenarios/byr/OUK/Order_download',
            ],
            [
                'byr_buyer_id' => 1,
                'slr_seller_id' => 0,
                'adm_role_id' => 5,
                'class' => 'order',
                'vector' => 'to_jacos',
                'name' => 'LEVEL3_TEST_SCENARIO',
                'description' => 'LEVEL3_TEST_SCENARIO',
                'file_path' => 'Scenarios/LV3/level3_test_scenario',
            ],
            [
                'byr_buyer_id' => 1,
                'slr_seller_id' => 0,
                'adm_role_id' => 5,
                'class' => 'receive',
                'vector' => 'to_jacos',
                'name' => 'DATA_RECEIVE_CSV_INSERTION',
                'description' => 'DATA_RECEIVE_CSV_INSERTION',
                'file_path' => 'Scenarios/byr/OUK/data_csv_receive',
            ],
            [
                'byr_buyer_id' => 1,
                'slr_seller_id' => 0,
                'adm_role_id' => 5,
                'class' => 'payment',
                'vector' => 'to_jacos',
                'name' => 'DATA_PAYMENT_CSV_INSERTION',
                'description' => 'DATA_PAYMENT_CSV_INSERTION',
                'file_path' => 'Scenarios/byr/OUK/data_csv_payment',
            ],
            [
                'byr_buyer_id' => 1,
                'slr_seller_id' => 0,
                'adm_role_id' => 5,
                'class' => 'order',
                'vector' => 'to_jacos',
                'name' => 'PDF_PLATFORM_VIEW',
                'description' => 'PDF_PLATFORM_VIEW',
                'file_path' => 'Scenarios/PDF/ouk_pdf_platform',
            ],
            [
                'byr_buyer_id' => 1,
                'slr_seller_id' => 0,
                'adm_role_id' => 5,
                'class' => 'invoice',
                'vector' => 'to_jacos',
                'name' => 'DATA_INVOICE_SCHEDULER',
                'description' => 'DATA_INVOICE_SCHEDULER',
                'file_path' => 'Scenarios/DATA/INVOICE/data_invoice_scheduler',
            ],
            [
                'byr_buyer_id' => 1,
                'slr_seller_id' => 0,
                'adm_role_id' => 5,
                'class' => 'return',
                'vector' => 'to_jacos',
                'name' => 'DATA_RETURN_CSV_IMPORT',
                'description' => 'DATA_RETURN_CSV_IMPORT',
                'file_path' => 'Scenarios/byr/OUK/data_csv_return',
            ],
        );
        cmn_scenario::insert($scenarios);
    }
}
