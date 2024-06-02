<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EmployeeSalarySetupsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('employee_salary_setups')->delete();
        
        
        
    }
}