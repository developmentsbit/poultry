<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CurrentPurchasesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('current_purchases')->delete();
        
        
        
    }
}