<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(permissionsTableDataSeeder::class);
        $this->call(rolesTableDataSeeder::class);
        $this->call(roleHasPermissionsTableDataSeeder::class);
        $this->call(modelHasrolesTableDataSeeder::class);
        // JCS Seeders  
        $this->call(Byr_shipment_detailSeeder::class); 
        $this->call(lv3_jobSeeder::class); 
        $this->call(lv3_trigger_file_pathSeeder::class); 
        $this->call(lv3_trigger_scheduleSeeder::class); 
        $this->call(lv3_historySeeder::class); 
    }
}