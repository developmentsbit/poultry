<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
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
                'id' => 1,
                'name' => 'Super Admin',
                'email' => 'super@admin.com',
                'mobile' => NULL,
                'email_verified_at' => NULL,
                'password' => Hash::make('super123'),
                'status' => 1,
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => '2023-03-18 19:07:28',
                'updated_at' => '2023-03-20 18:18:31',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'mobile' => NULL,
                'email_verified_at' => NULL,
                'password' => Hash::make('admin123'),
                'status' => 1,
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => '2023-03-18 19:07:28',
                'updated_at' => '2023-03-20 18:18:31',
            ),
        ));


    }
}
