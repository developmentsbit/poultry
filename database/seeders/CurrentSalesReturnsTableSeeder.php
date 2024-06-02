<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CurrentSalesReturnsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('current_sales_returns')->delete();
        
        
        
    }
}