<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductBrandsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('product_brands')->delete();
        
        \DB::table('product_brands')->insert(array (
            0 => 
            array (
                'brand_admin_id' => '1',
                'brand_id' => 'BRN-000001',
                'brand_name_bn' => NULL,
                'brand_name_en' => 'SBIT',
                'brand_status' => '1',
                'created_at' => '2023-05-16 12:13:47',
                'deleted_at' => NULL,
                'id' => 1,
                'updated_at' => '2023-05-16 12:13:47',
            ),
        ));
        
        
    }
}