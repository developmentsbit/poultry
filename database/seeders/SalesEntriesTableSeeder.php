<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SalesEntriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sales_entries')->delete();
        
        \DB::table('sales_entries')->insert(array (
            0 => 
            array (
                'admin_id' => '1',
                'branch_id' => '1',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'entry_date' => '2023-05-16',
                'id' => 1,
                'invoice_no' => 'SI-0000001',
                'note' => 'TEST',
                'product_discount_amount' => 0.0,
                'product_id' => 'PDT-000001',
                'product_purchase_price' => 500.0,
                'product_quantity' => 1.0,
                'product_sales_price' => 530.0,
                'return_quantity' => NULL,
                'status' => NULL,
                'sub_unit_id' => '1',
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'admin_id' => '1',
                'branch_id' => '1',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'entry_date' => '2023-05-16',
                'id' => 2,
                'invoice_no' => 'SI-0000002',
                'note' => NULL,
                'product_discount_amount' => 0.0,
                'product_id' => 'PDT-000001',
                'product_purchase_price' => 500.0,
                'product_quantity' => 2.0,
                'product_sales_price' => 530.0,
                'return_quantity' => NULL,
                'status' => NULL,
                'sub_unit_id' => '1',
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}