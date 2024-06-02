<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class InternalLoanRecivedsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('internal_loan_reciveds')->delete();
        
        \DB::table('internal_loan_reciveds')->insert(array (
            0 => 
            array (
                'amount' => 5000.0,
                'branch' => 1,
                'created_at' => '2023-05-18 07:21:31',
                'date' => '2023-05-18',
                'deleted_at' => NULL,
                'id' => 1,
                'note' => 'test',
                'register_id' => 1,
                'updated_at' => '2023-05-18 07:34:40',
            ),
        ));
        
        
    }
}