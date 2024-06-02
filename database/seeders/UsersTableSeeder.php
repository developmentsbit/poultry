<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'branch' => 1,
                'created_at' => '2023-03-18 19:07:28',
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'dob' => NULL,
                'email' => 'super@admin.com',
                'email_verified_at' => NULL,
                'id' => 1,
                'mobile' => NULL,
                'name' => 'Super Admin',
                'password' => '$2y$10$2d1XYsMZ0JNEsW3iWSyOvuNSdQVfvjA0PT5DfBSazSbHPDHt7QhD2',
                'picture' => NULL,
                'remember_token' => NULL,
                'status' => 1,
                'updated_at' => '2023-03-20 18:18:31',
            ),
            1 => 
            array (
                'branch' => 1,
                'created_at' => '2023-03-18 19:07:28',
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'dob' => NULL,
                'email' => 'admin@admin.com',
                'email_verified_at' => NULL,
                'id' => 2,
                'mobile' => NULL,
                'name' => 'Admin',
                'password' => '$2y$10$WS2AMzS24hPzI7vkVyDfE.3b4yi.bGqy7b4ptS9DwCbqUJ05zpQFC',
                'picture' => NULL,
                'remember_token' => NULL,
                'status' => 1,
                'updated_at' => '2023-03-20 18:18:31',
            ),
        ));
        
        
    }
}