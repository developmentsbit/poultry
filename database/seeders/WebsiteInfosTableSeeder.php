<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class WebsiteInfosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('website_infos')->delete();
        
        \DB::table('website_infos')->insert(array (
            0 => 
            array (
                'adress' => 'Feni',
                'banner' => '1258888655.jpg',
                'company_name' => 'Test',
                'created_at' => NULL,
                'email' => 'tanimchy417@gmail.com',
                'facebook' => 'https://facebook.com',
                'favicon' => '1057156024.jpg',
                'id' => 1,
                'instagram' => 'https://instagram.com',
                'linkedin' => 'https://linkedin.com',
                'logo' => '2007088820.jpg',
                'phone1' => '01575434262',
                'phone2' => '01872583429',
                'title' => 'Test',
                'twiiter' => 'https://twitter.com',
                'updated_at' => '2023-05-02 11:17:54',
                'youtube' => 'https://youtube.com',
            ),
        ));
        
        
    }
}