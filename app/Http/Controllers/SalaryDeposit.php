<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use Auth;
use App\Models\employee_salary_payment;
use App\Models\employee_salary_setup;

class SalaryDeposit extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $salary = $request->employee_id;

        foreach($salary as $s)
        {
            $check = employee_salary_payment::where('employee_id',$s)->where('month',$request->month)->where('year',$request->year)->first();

            $data = employee_salary_setup::where('employee_id',$s)->get();

            if($check)
            {

            }
            else
            {
                foreach($data as $v)
                {

                    employee_salary_payment::create([
                        'employee_id'=>$s,
                        'month'=>$request->month,
                        'year'=>$request->year,
                        'salary_deposit'=>$v->employee_salary,
                        'date'=>date('Y-m-d'),
                        'admin_id'=>Auth::user()->id,
                        'branch_id'=>Auth::user()->branch,
                    ]);
                }
            }
        }

        Toastr::success('Employee Salary Deposit Successfully', 'Success');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
