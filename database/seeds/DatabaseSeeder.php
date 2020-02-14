<?php

use App\Model\Role_Permission;
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
        // $this->call(UsersTableSeeder::class);
        // $this->call(PermissionSeeder::class);
        // $this->call(RoleTableSeeder::class);
        // $this->call(RolePermissionTableSeeder::class);
        $this->call(TagTableSeeder::class);
        
    }
}
