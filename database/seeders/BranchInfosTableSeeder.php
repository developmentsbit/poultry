<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BranchInfosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('branch_infos')->delete();
        
        \DB::table('branch_infos')->insert(array (
            0 => 
            array (
                'branch_address_bn' => 'মিজান রোড, ফেনী',
                'branch_address_en' => 'Mizan Road, Feni',
                'branch_email' => 'fenibranch@gmail.com',
                'branch_mobile' => '0187896586',
                'branch_name_bn' => 'ফেনী',
                'branch_name_en' => 'Feni',
                'company_id' => 1,
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1,
                'official_contact _no' => '+88845646512',
                'sl' => 1,
                'status' => 1,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}