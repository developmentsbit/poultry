<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class IncomeExpenseTitlesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('income_expense_titles')->delete();
        
        
        
    }
}