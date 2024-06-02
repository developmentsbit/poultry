<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CurrentSalesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('current_sales')->delete();
        
        
        
    }
}