<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SalesLedgersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sales_ledgers')->delete();
        
        \DB::table('sales_ledgers')->insert(array (
            0 => 
            array (
                'admin_id' => '1',
                'branch_id' => '1',
                'created_at' => NULL,
                'customer_id' => 'C-00001',
                'deleted_at' => NULL,
                'entry_date' => '2023-05-16',
                'final_discount' => 60.0,
                'id' => 1,
                'invoice_date' => '2023-05-16',
                'invoice_no' => 'SI-0000001',
                'note' => NULL,
                'paid_amount' => 900.0,
                'return_amount' => NULL,
                'status' => NULL,
                'total' => 1060.0,
                'transaction_type' => 'Cash',
                'updated_at' => NULL,
                'vat' => NULL,
            ),
            1 => 
            array (
                'admin_id' => '1',
                'branch_id' => '1',
                'created_at' => NULL,
                'customer_id' => 'C-00001',
                'deleted_at' => NULL,
                'entry_date' => '2023-05-16',
                'final_discount' => 60.0,
                'id' => 2,
                'invoice_date' => '2023-05-16',
                'invoice_no' => 'SI-0000002',
                'note' => NULL,
                'paid_amount' => 900.0,
                'return_amount' => NULL,
                'status' => NULL,
                'total' => 1060.0,
                'transaction_type' => 'Cash',
                'updated_at' => NULL,
                'vat' => NULL,
            ),
        ));
        
        
    }
}