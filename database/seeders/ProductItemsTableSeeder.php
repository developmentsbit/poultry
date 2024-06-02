<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('product_items')->delete();
        
        \DB::table('product_items')->insert(array (
            0 => 
            array (
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1,
                'item_admin_id' => '1',
                'item_id' => 'ITM-000001',
                'item_name_bn' => 'আম',
                'item_name_en' => 'Mango',
                'item_status' => '1',
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}