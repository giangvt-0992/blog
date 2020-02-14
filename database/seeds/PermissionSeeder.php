<?php

use Illuminate\Database\Seeder;
use App\Model\Permission;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(Permission::class, 3)->create();
        DB::table('permissions')->insert(array(
            ['permission' => 'create post'],            
            ['permission' => 'view post'],
            ['permission' => 'delete post'],
            ['permission' => 'update post'],
            ['permission' => 'delete ticket'],
            ['permission' => 'update ticket'],
            ['permission' => 'delete comment'],
            ['permission' => 'update comment'],
        ));
    }
}
