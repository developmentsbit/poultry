<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use Auth;
use App\Models\employee_salary_setup;
use App\Models\employee_info;

class SalarySetupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = employee_salary_setup::leftjoin('employee_infos','employee_infos.id','employee_salary_setups.employee_id')
                ->where('employee_salary_setups.branch_id',Auth::user()->branch)
                ->select('employee_salary_setups.*','employee_infos.name')
                ->get();
        return view('inventory.salary_setup.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $emp = employee_info::get();
        return view('inventory.salary_setup.create',compact('emp'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $check = employee_salary_setup::where('employee_id',$request->employee_id)->count();

        if($check != '0')
        {
            Toastr::warning('This Employee Has Already Setup Salary', 'Warning');
            return redirect('/salary_setup');
        }
        else
        {

            $data = array(
                'employee_id'=>$request->employee_id,
                'employee_salary'=>$request->employee_salary,
                'status'=>$request->status,
                'admin_id'=>Auth::user()->id,
                'branch_id'=>Auth::user()->branch,
                'date'=>date('Y-m-d'),
            );

            employee_salary_setup::create($data);
            Toastr::success('Employee Salary Setup Successufully', 'Success');
            return redirect('/salary_setup');
        }

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
        $emp = employee_info::get();
        $data = employee_salary_setup::find($id);
        return view('inventory.salary_setup.edit',compact('data','emp'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = array(
            'employee_id'=>$request->employee_id,
            'employee_salary'=>$request->employee_salary,
            'status'=>$request->status,
            'admin_id'=>Auth::user()->id,
            'branch_id'=>Auth::user()->branch,
            'date'=>date('Y-m-d'),
        );

        employee_salary_setup::find($id)->update($data);
        Toastr::success('Employee Salary Update Successufully', 'Success');
        return redirect('/salary_setup');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        employee_salary_setup::find($id)->delete();
        Toastr::success('Employee Salary Delete Successufully', 'Success');
        return redirect('/salary_setup');
    }

    public function employee_salary_deposit(Request $request)
    {
        dd($request->all());
    }
}
