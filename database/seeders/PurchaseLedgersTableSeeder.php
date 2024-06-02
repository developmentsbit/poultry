<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PurchaseLedgersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('purchase_ledgers')->delete();
        
        \DB::table('purchase_ledgers')->insert(array (
            0 => 
            array (
                'id' => 2,
                'invoice_no' => 'PI-0000001',
                'invoice_date' => '2023-05-29',
                'voucher_no' => NULL,
                'voucher_date' => '2023-05-29',
                'suplier_id' => 'C-00002',
                'total' => 300.0,
                'paid' => 300.0,
                'discount' => 0.0,
                'return_amount' => NULL,
                'transaction_type' => 'Cash',
                'comment' => NULL,
                'entry_date' => '2023-05-29',
                'branch_id' => '1',
                'status' => NULL,
                'admin_id' => '1',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}