<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MigrationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('migrations')->delete();
        
        \DB::table('migrations')->insert(array (
            0 => 
            array (
                'batch' => 1,
                'id' => 1,
                'migration' => '2014_10_05_000000_create_users_table',
            ),
            1 => 
            array (
                'batch' => 1,
                'id' => 2,
                'migration' => '2014_10_07_100003_create_menus_table',
            ),
            2 => 
            array (
                'batch' => 1,
                'id' => 3,
                'migration' => '2014_10_08_100004_create_menu_actions_table',
            ),
            3 => 
            array (
                'batch' => 1,
                'id' => 4,
                'migration' => '2014_10_09_100005_create_user_menu_actions_table',
            ),
            4 => 
            array (
                'batch' => 1,
                'id' => 5,
                'migration' => '2014_10_12_100000_create_password_reset_tokens_table',
            ),
            5 => 
            array (
                'batch' => 1,
                'id' => 6,
                'migration' => '2014_10_12_100000_create_password_resets_table',
            ),
            6 => 
            array (
                'batch' => 1,
                'id' => 7,
                'migration' => '2019_08_19_000000_create_failed_jobs_table',
            ),
            7 => 
            array (
                'batch' => 1,
                'id' => 8,
                'migration' => '2019_12_14_000001_create_personal_access_tokens_table',
            ),
            8 => 
            array (
                'batch' => 1,
                'id' => 9,
                'migration' => '2023_03_16_155056_create_permission_tables',
            ),
            9 => 
            array (
                'batch' => 1,
                'id' => 10,
                'migration' => '2023_04_05_213434_create_otp_sms_table',
            ),
            10 => 
            array (
                'batch' => 1,
                'id' => 11,
                'migration' => '2023_04_19_055008_create_company_infos_table',
            ),
            11 => 
            array (
                'batch' => 1,
                'id' => 12,
                'migration' => '2023_04_19_063729_create_customer_infos_table',
            ),
            12 => 
            array (
                'batch' => 1,
                'id' => 13,
                'migration' => '2023_04_19_070841_create_branch_infos_table',
            ),
            13 => 
            array (
                'batch' => 3,
                'id' => 17,
                'migration' => '2023_04_29_094822_create_supplier_infos_table',
            ),
            14 => 
            array (
                'batch' => 4,
                'id' => 21,
                'migration' => '2023_04_30_043940_create_product_items_table',
            ),
            15 => 
            array (
                'batch' => 5,
                'id' => 22,
                'migration' => '2023_04_30_054945_create_product_categories_table',
            ),
            16 => 
            array (
                'batch' => 6,
                'id' => 23,
                'migration' => '2023_05_01_045842_create_product_brands_table',
            ),
            17 => 
            array (
                'batch' => 7,
                'id' => 24,
                'migration' => '2023_05_01_054852_create_product_informations_table',
            ),
            18 => 
            array (
                'batch' => 8,
                'id' => 26,
                'migration' => '2023_05_01_055835_create_product_measurements_table',
            ),
            19 => 
            array (
                'batch' => 10,
                'id' => 28,
                'migration' => '2023_05_02_051308_create_measurement_subunits_table',
            ),
            20 => 
            array (
                'batch' => 11,
                'id' => 29,
                'migration' => '2023_05_02_084443_create_purchase_ledgers_table',
            ),
            21 => 
            array (
                'batch' => 11,
                'id' => 30,
                'migration' => '2023_05_02_084455_create_purchase_entries_table',
            ),
            22 => 
            array (
                'batch' => 11,
                'id' => 31,
                'migration' => '2023_05_02_084505_create_stocks_table',
            ),
            23 => 
            array (
                'batch' => 12,
                'id' => 32,
                'migration' => '2023_04_29_044557_create_sales_payments_table',
            ),
            24 => 
            array (
                'batch' => 13,
                'id' => 34,
                'migration' => '2023_04_29_095213_create_supplier_payments_table',
            ),
            25 => 
            array (
                'batch' => 14,
                'id' => 35,
                'migration' => '2023_05_02_105026_create_website_infos_table',
            ),
            26 => 
            array (
                'batch' => 16,
                'id' => 37,
                'migration' => '2023_05_01_105325_create_current_purchases_table',
            ),
            27 => 
            array (
                'batch' => 17,
                'id' => 38,
                'migration' => '2023_05_03_075831_create_current_sales_table',
            ),
            28 => 
            array (
                'batch' => 18,
                'id' => 39,
                'migration' => '2023_05_03_121513_create_sales_entries_table',
            ),
            29 => 
            array (
                'batch' => 18,
                'id' => 40,
                'migration' => '2023_05_03_121714_create_sales_ledgers_table',
            ),
            30 => 
            array (
                'batch' => 19,
                'id' => 42,
                'migration' => '2023_05_08_051454_create_current_sales_returns_table',
            ),
        ));
        
        
    }
}