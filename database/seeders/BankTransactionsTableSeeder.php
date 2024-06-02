<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BankTransactionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('bank_transactions')->delete();
        
        
        
    }
}