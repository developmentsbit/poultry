<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LoanRegistersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('loan_registers')->delete();
        
        \DB::table('loan_registers')->insert(array (
            0 => 
            array (
                'address' => 'Feni',
                'admin' => 1,
                'branch' => 1,
                'created_at' => '2023-05-17 08:51:41',
                'deleted_at' => NULL,
                'id' => 1,
                'name' => 'Sumsul Karim',
                'phone' => '01575434262',
                'updated_at' => '2023-05-18 06:52:06',
            ),
        ));
        
        
    }
}