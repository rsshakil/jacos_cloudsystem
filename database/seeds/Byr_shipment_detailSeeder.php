<?php

use Illuminate\Database\Seeder;

class Byr_shipment_detailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Byr_shipment_detail::class, 3)->create();
    }
}
