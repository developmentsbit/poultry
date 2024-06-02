<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SalesPaymentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sales_payments')->delete();
        
        \DB::table('sales_payments')->insert(array (
            0 => 
            array (
                'admin_id' => 1,
                'branch_id' => '1',
                'created_at' => NULL,
                'customer_id' => 'C-00001',
                'deleted_at' => NULL,
                'discount' => NULL,
                'entry_date' => '2023-05-16',
                'id' => 1,
                'invoice_no' => 'SI-0000001',
                'note' => 'firstpayment',
                'payment_amount' => 900.0,
                'payment_type' => 'Cash',
                'previous_due' => NULL,
                'return_amount' => NULL,
                'returnpaid' => NULL,
                'status' => NULL,
                'transaction_type' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'admin_id' => 1,
                'branch_id' => '1',
                'created_at' => NULL,
                'customer_id' => 'C-00001',
                'deleted_at' => NULL,
                'discount' => NULL,
                'entry_date' => '2023-05-16',
                'id' => 2,
                'invoice_no' => 'SI-0000002',
                'note' => 'firstpayment',
                'payment_amount' => 900.0,
                'payment_type' => 'Cash',
                'previous_due' => NULL,
                'return_amount' => NULL,
                'returnpaid' => NULL,
                'status' => NULL,
                'transaction_type' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}