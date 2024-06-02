<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OtpSmsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('otp_sms')->delete();
        
        \DB::table('otp_sms')->insert(array (
            0 => 
            array (
                'country_code' => '+880',
                'created_at' => '2023-04-06 06:07:50',
                'created_by' => NULL,
                'expire_at' => NULL,
                'id' => 1,
                'message' => 'Dear Sumsul Karim, Your account has been created successfully. Your login Username: NF23000001 & Password: . NAJRAN Fisheries & Agros.',
                'otp' => NULL,
                'phone' => '1575434262',
                'response' => NULL,
                'updated_at' => '2023-04-06 06:07:50',
                'user_id' => NULL,
            ),
            1 => 
            array (
                'country_code' => '+880',
                'created_at' => '2023-04-06 06:09:39',
                'created_by' => NULL,
                'expire_at' => NULL,
                'id' => 2,
                'message' => 'Dear Sumsul Karim, Your account has been created successfully. Your login Username: NF23000002 & Password: . NAJRAN Fisheries & Agros.',
                'otp' => NULL,
                'phone' => '1575434262',
                'response' => NULL,
                'updated_at' => '2023-04-06 06:09:39',
                'user_id' => NULL,
            ),
            2 => 
            array (
                'country_code' => '+880',
                'created_at' => '2023-04-06 06:10:14',
                'created_by' => NULL,
                'expire_at' => NULL,
                'id' => 3,
                'message' => 'Dear Sumsul Karim, Your account has been created successfully. Your login Username: NF23000003 & Password: 123. NAJRAN Fisheries & Agros.',
                'otp' => NULL,
                'phone' => '1575434262',
                'response' => NULL,
                'updated_at' => '2023-04-06 06:10:14',
                'user_id' => NULL,
            ),
            3 => 
            array (
                'country_code' => '+880',
                'created_at' => '2023-04-06 06:10:40',
                'created_by' => NULL,
                'expire_at' => NULL,
                'id' => 4,
                'message' => 'Dear Sumsul Karim, Your account has been created successfully. Your login Username: NF23000004 & Password: 12345678. NAJRAN Fisheries & Agros.',
                'otp' => NULL,
                'phone' => '1575434262',
                'response' => NULL,
                'updated_at' => '2023-04-06 06:10:40',
                'user_id' => NULL,
            ),
            4 => 
            array (
                'country_code' => '+880',
                'created_at' => '2023-04-06 06:12:07',
                'created_by' => NULL,
                'expire_at' => NULL,
                'id' => 5,
                'message' => 'Dear TETS, Your account has been created successfully. Your login Username: NF23000006 & Password: 12345678. NAJRAN Fisheries & Agros.',
                'otp' => NULL,
                'phone' => '1575434262',
                'response' => NULL,
                'updated_at' => '2023-04-06 06:12:07',
                'user_id' => NULL,
            ),
            5 => 
            array (
                'country_code' => '+880',
                'created_at' => '2023-04-06 06:31:00',
                'created_by' => NULL,
                'expire_at' => NULL,
                'id' => 6,
                'message' => 'Dear Sumsul Karim, Your account has been created successfully. Your login Username: NF23000003 & Password: 123. NAJRAN Fisheries & Agros.',
                'otp' => NULL,
                'phone' => '1575434262',
                'response' => NULL,
                'updated_at' => '2023-04-06 06:31:00',
                'user_id' => NULL,
            ),
            6 => 
            array (
                'country_code' => '+880',
                'created_at' => '2023-04-06 06:31:59',
                'created_by' => NULL,
                'expire_at' => NULL,
                'id' => 7,
                'message' => 'Dear Sumsul Karim, Your account has been created successfully. Your login Username: NF23000004 & Password: 123456. NAJRAN Fisheries & Agros.',
                'otp' => NULL,
                'phone' => '1575434262',
                'response' => NULL,
                'updated_at' => '2023-04-06 06:31:59',
                'user_id' => NULL,
            ),
        ));
        
        
    }
}