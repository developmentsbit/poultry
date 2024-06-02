<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class IncomeEntriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('income_entries')->delete();
        
        
        
    }
}