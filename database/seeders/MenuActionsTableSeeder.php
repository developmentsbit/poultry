<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MenuActionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('menu_actions')->delete();
        
        \DB::table('menu_actions')->insert(array (
            0 => 
            array (
                'bn_name' => 'সংযোজন',
                'button_class' => 'btn btn-primary btn-sm',
                'created_at' => '2021-02-25 09:45:31',
                'created_by' => NULL,
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'icon' => 'fa fa-plus-circle',
                'id' => 1,
                'name' => 'Create',
                'order_by' => 1,
                'slug' => 'create',
                'status' => 1,
                'system_name' => NULL,
                'updated_at' => '2021-02-25 09:49:31',
                'updated_by' => NULL,
            ),
            1 => 
            array (
                'bn_name' => 'পরিমার্জন',
                'button_class' => 'btn btn-warning btn-sm edit',
                'created_at' => '2021-02-25 09:47:13',
                'created_by' => NULL,
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'icon' => 'fa fa-edit',
                'id' => 2,
                'name' => 'Edit',
                'order_by' => 2,
                'slug' => 'edit',
                'status' => 1,
                'system_name' => NULL,
                'updated_at' => '2021-04-04 05:15:15',
                'updated_by' => NULL,
            ),
            2 => 
            array (
                'bn_name' => 'মুছুন',
                'button_class' => 'btn btn-danger btn-sm destroy',
                'created_at' => '2021-02-25 09:48:38',
                'created_by' => NULL,
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'icon' => 'fa fa-trash-alt',
                'id' => 3,
                'name' => 'Delete',
                'order_by' => 4,
                'slug' => 'delete',
                'status' => 1,
                'system_name' => NULL,
                'updated_at' => '2021-02-28 12:33:46',
                'updated_by' => NULL,
            ),
            3 => 
            array (
                'bn_name' => 'দেখুন',
                'button_class' => 'btn btn-info btn-sm',
                'created_at' => '2021-02-27 08:58:40',
                'created_by' => NULL,
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'icon' => 'fa fa-eye',
                'id' => 4,
                'name' => 'View',
                'order_by' => 3,
                'slug' => 'view',
                'status' => 1,
                'system_name' => NULL,
                'updated_at' => '2021-02-27 10:16:44',
                'updated_by' => NULL,
            ),
            4 => 
            array (
                'bn_name' => 'অনুমতি',
                'button_class' => 'btn btn-primary btn-sm',
                'created_at' => '2021-03-18 10:38:54',
                'created_by' => NULL,
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'icon' => 'fa fa-lock',
                'id' => 5,
                'name' => 'Permission',
                'order_by' => 5,
                'slug' => 'permission',
                'status' => 1,
                'system_name' => NULL,
                'updated_at' => '2021-03-18 10:38:54',
                'updated_by' => NULL,
            ),
            5 => 
            array (
                'bn_name' => 'ভিন্ন',
                'button_class' => 'btn btn-warning btn-sm order',
                'created_at' => '2021-03-24 11:28:00',
                'created_by' => NULL,
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'icon' => 'fa fa-gavel',
                'id' => 6,
                'name' => 'Order',
                'order_by' => 6,
                'slug' => 'order',
                'status' => 1,
                'system_name' => NULL,
                'updated_at' => '2021-03-24 11:28:00',
                'updated_by' => NULL,
            ),
            6 => 
            array (
                'bn_name' => 'চিহ্ন',
                'button_class' => 'btn btn-primary btn-sm',
                'created_at' => '2021-04-05 10:07:08',
                'created_by' => NULL,
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'icon' => 'fa fa-check',
                'id' => 7,
                'name' => 'Check',
                'order_by' => 7,
                'slug' => 'check',
                'status' => 1,
                'system_name' => NULL,
                'updated_at' => '2021-04-05 10:16:41',
                'updated_by' => NULL,
            ),
            7 => 
            array (
                'bn_name' => 'মুদ্রণ',
                'button_class' => 'btn btn-primary btn-sm',
                'created_at' => '2021-05-08 06:03:01',
                'created_by' => NULL,
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'icon' => 'fas fa-print',
                'id' => 8,
                'name' => 'Print',
                'order_by' => 8,
                'slug' => 'print',
                'status' => 1,
                'system_name' => NULL,
                'updated_at' => '2021-05-08 06:03:10',
                'updated_by' => NULL,
            ),
            8 => 
            array (
                'bn_name' => 'পুনরুদ্ধার',
                'button_class' => 'btn btn-warning btn-sm restore',
                'created_at' => '2021-07-12 11:14:14',
                'created_by' => NULL,
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'icon' => 'fa fa-undo',
                'id' => 9,
                'name' => 'Restore',
                'order_by' => 9,
                'slug' => 'restore',
                'status' => 1,
                'system_name' => NULL,
                'updated_at' => '2021-07-12 11:37:10',
                'updated_by' => NULL,
            ),
            9 => 
            array (
                'bn_name' => 'পরিমার্জনের ইতিহাস',
                'button_class' => 'btn btn-info btn-sm edit_history',
                'created_at' => '2021-10-31 05:52:20',
                'created_by' => 1,
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'icon' => 'fas fa-history',
                'id' => 10,
                'name' => 'Edit-History',
                'order_by' => 10,
                'slug' => 'edit_history',
                'status' => 1,
                'system_name' => NULL,
                'updated_at' => '2021-11-01 09:37:48',
                'updated_by' => 1,
            ),
        ));
        
        
    }
}