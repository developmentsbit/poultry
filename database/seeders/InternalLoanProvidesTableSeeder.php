<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class InternalLoanProvidesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('internal_loan_provides')->delete();
        
        \DB::table('internal_loan_provides')->insert(array (
            0 => 
            array (
                'amount' => 4000.0,
                'branch' => 1,
                'created_at' => '2023-05-18 09:25:20',
                'date' => '2023-05-18',
                'deleted_at' => NULL,
                'id' => 1,
                'note' => 'test',
                'register_id' => 1,
                'updated_at' => '2023-05-18 09:25:20',
            ),
        ));
        
        
    }
}