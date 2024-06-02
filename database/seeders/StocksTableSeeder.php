<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StocksTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('stocks')->delete();
        
        \DB::table('stocks')->insert(array (
            0 => 
            array (
                'branch_id' => '1',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1,
                'invoice_no' => 'PI-0000001',
                'old_and_new_purchase_price_average' => NULL,
                'pdt_expiry_date' => NULL,
                'product_id' => 'PDT-000001',
                'purchase_price' => 500.0,
                'purchase_price_withcost' => 500.0,
                'quantity' => 10.0,
                'sale_price' => 530.0,
                'sales_qty' => 3.0,
                'status' => NULL,
                'stock_qun' => NULL,
                'updated_at' => '2023-05-16 12:18:37',
            ),
        ));
        
        
    }
}