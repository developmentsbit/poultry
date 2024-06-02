<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LoanRecivedsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('loan_reciveds')->delete();
        
        \DB::table('loan_reciveds')->insert(array (
            0 => 
            array (
                'amount' => 50000.0,
                'branch' => 1,
                'created_at' => '2023-05-17 10:29:26',
                'date' => '2023-05-17',
                'deleted_at' => NULL,
                'id' => 2,
                'note' => NULL,
                'register_id' => 1,
                'updated_at' => '2023-05-17 10:29:26',
            ),
        ));
        
        
    }
}