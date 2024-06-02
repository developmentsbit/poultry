<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BankInfosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('bank_infos')->delete();
        
        \DB::table('bank_infos')->insert(array (
            0 => 
            array (
                'id' => 1,
                'bank_name' => 'Islami Bank Bangladesh',
                'account_number' => '894894894894',
                'details' => NULL,
                'contact' => '01575434262',
                'account_type' => 'Saving',
                'bankingType' => 'Internet',
                'admin' => 1,
                'branch_id' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'bank_name' => 'RUPALI BANK LTD.',
                'account_number' => '2584182000019',
                'details' => NULL,
                'contact' => '01861969736',
                'account_type' => 'CC LONE',
                'bankingType' => 'CURENT',
                'admin' => 1,
                'branch_id' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'bank_name' => 'Shahjalal Islami Bank',
                'account_number' => '7897894364865',
                'details' => 'Demo',
                'contact' => '01575434262',
                'account_type' => 'CC Loan',
                'bankingType' => 'Internet',
                'admin' => 1,
                'branch_id' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}