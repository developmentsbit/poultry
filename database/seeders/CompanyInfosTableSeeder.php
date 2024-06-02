<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CompanyInfosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('company_infos')->delete();
        
        \DB::table('company_infos')->insert(array (
            0 => 
            array (
                'banner' => '1427320175.jpg',
                'company_address_bn' => NULL,
            'company_address_en' => '১৩ নং হাজী প্লাজা (জিরি মাদ্রাসার গেইট সংলগ্ন), শান্তির হাট, পটিয়া, চট্টগ্রাম।',
                'company_contact_no' => '01840241895',
                'company_email' => 'info@skillbasedit.com',
                'company_mobile' => '01854505050',
                'company_name_bn' => NULL,
                'company_name_en' => 'আরশি পোল্ট্রি',
                'created_at' => NULL,
                'date' => '2023-04-01',
                'deleted_at' => NULL,
                'id' => 1,
                'logo' => '1400555863.png',
                'openingbalance' => 50000.0,
                'status' => 1,
                'updated_at' => '2023-05-16 11:35:39',
                'vat' => 5,
            ),
        ));
        
        
    }
}