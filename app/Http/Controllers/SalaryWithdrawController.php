<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use Auth;
use App\Models\employee_salary_payment;
use App\Models\employee_salary_setup;
use App\Models\employee_info;

class SalaryWithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = employee_salary_payment::leftjoin('employee_infos','employee_infos.id','employee_salary_payments.employee_id')
            ->select('employee_salary_payments.*','employee_infos.name')
            ->where('employee_salary_payments.salary_withdraw','!=',NULL)
            ->get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<div class="dropdown">
                    <a class="btn btn-secondary dropdown-toggle btn-sm" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <form action="'.route('salary_withdraw.destroy',$row->id).'" method="post">
                        '.csrf_field().'
                        '.method_field("DELETE").'
                        <button onclick="return Confirm()" type="submit" class="dropdown-item text-danger"><i class="fa fa-trash"></i> Delete</button>
                        </form>
                    </div>
                </div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);


        }
        return view('inventory.salary_withdraw.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $emp = employee_info::get();
        return view('inventory.salary_withdraw.create',compact('emp'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $insert = employee_salary_payment::create([
            'date'=>$request->date,
            'employee_id'=>$request->employee_id,
            'salary_withdraw'=>$request->salary_withdraw,
            'transaction_type'=>$request->transaction_type,
            'note'=>$request->note,
            'admin_id'=>Auth::user()->id,
            'branch_id'=>Auth::user()->branch,
        ]);

        Toastr::success('Employee Salary Withdraw Successfully', 'Success');
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
        employee_salary_payment::find($id)->delete();
        Toastr::success('Employee Salary Delete Successfully', 'Success');
        return redirect()->back();

    }


    public function getEmpBalance(Request $request)
    {
        $deposit = employee_salary_payment::where('employee_id',$request->emp_id)->sum('salary_deposit');

        $withdraw = employee_salary_payment::where('employee_id',$request->emp_id)->sum('salary_withdraw');

        $result = $deposit - $withdraw;

        return $result;
    }
}
