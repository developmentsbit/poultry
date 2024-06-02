<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductInformationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('product_informations')->delete();
        
        \DB::table('product_informations')->insert(array (
            0 => 
            array (
                'barcode' => '9496',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1,
                'pdt_admin_id' => '1',
                'pdt_brand_id' => 'BRN-000001',
                'pdt_cat_id' => 'CAT-000001',
                'pdt_id' => 'PDT-000001',
                'pdt_item_id' => 'ITM-000001',
                'pdt_measurement' => 'MU-0000001',
                'pdt_name_bn' => 'হাড়ীভাঙ্গা আম',
                'pdt_name_en' => 'Harivanga Mango',
                'pdt_purchase_price' => '500',
                'pdt_sale_price' => '530',
                'pdt_status' => '1',
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}