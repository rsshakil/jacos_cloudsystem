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
    }
}
