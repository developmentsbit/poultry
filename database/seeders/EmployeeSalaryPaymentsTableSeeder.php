<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EmployeeSalaryPaymentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('employee_salary_payments')->delete();
        
        
        
    }
}