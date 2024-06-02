<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('product_categories')->delete();
        
        \DB::table('product_categories')->insert(array (
            0 => 
            array (
                'cat_admin_id' => '1',
                'cat_id' => 'CAT-000001',
                'cat_item_id' => 'ITM-000001',
                'cat_name_bn' => 'রাজশাহী আম',
                'cat_name_en' => 'Rajshahi Mango',
                'cat_status' => '1',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}