<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SupplierPaymentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('supplier_payments')->delete();
        
        \DB::table('supplier_payments')->insert(array (
            0 => 
            array (
                'id' => 2,
                'invoice_no' => 'PI-0000001',
                'payment_date' => '2023-05-29',
                'supplier_id' => 'C-00002',
                'payment' => 300.0,
                'payment_type' => 'Cash',
                'return_amount' => 0.0,
                'returnpaid' => NULL,
                'discount' => NULL,
                'previous_due' => NULL,
                'entry_date' => '2023-05-29',
                'admin_id' => 1,
                'comment' => 'firstpayment',
                'branch_id' => '1',
                'transaction_type' => NULL,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}