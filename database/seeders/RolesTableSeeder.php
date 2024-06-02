<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'created_at' => '2023-03-19 15:34:59',
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'guard_name' => 'web',
                'id' => 1,
                'name' => 'Super Admin',
                'status' => 1,
                'updated_at' => '2023-03-23 08:58:55',
            ),
            1 => 
            array (
                'created_at' => '2023-03-19 15:34:59',
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'guard_name' => 'web',
                'id' => 2,
                'name' => 'Admin',
                'status' => 1,
                'updated_at' => '2023-03-23 08:58:55',
            ),
            2 => 
            array (
                'created_at' => '2023-03-30 17:49:59',
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'guard_name' => 'web',
                'id' => 3,
                'name' => 'User',
                'status' => 1,
                'updated_at' => '2023-03-30 17:49:59',
            ),
        ));
        
        
    }
}