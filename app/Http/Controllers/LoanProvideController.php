<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use Auth;
use App\Models\loan_register;
use App\Models\loan_recived;
use App\Models\loan_provide;

class LoanProvideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = loan_provide::leftjoin('loan_registers','loan_registers.id','loan_provides.register_id')
            ->select('loan_provides.*','loan_registers.name')
            ->get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('sl',function($row){
                $i = 1;
                return $i++;
            })
            ->addColumn('action', function($row){
                $btn = '<div class="dropdown">
                    <a class="btn btn-secondary dropdown-toggle btn-sm" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a onclick="return Confirm()" class="dropdown-item" href="'.route('loan_provide.edit',$row->id).'"><i class="fa fa-edit"></i> Edit</a>
                        <form action="'.route('loan_provide.destroy',$row->id).'" method="post">
                        '.csrf_field().'
                        '.method_field("DELETE").'
                        <button onclick="return Confirm()" type="submit" class="dropdown-item text-danger"><i class="fa fa-trash"></i> Delete</button>
                        </form>
                    </div>
                </div>';
                return $btn;
            })
            ->rawColumns(['action','sl'])
            ->make(true);


        }
        return view('inventory.loan_provide.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $register = loan_register::get();
        return view('inventory.loan_provide.create',compact('register'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = array(
            'date'=>$request->date,
            'register_id'=>$request->register_id,
            'amount'=>$request->amount,
            'note'=>$request->note,
            'branch'=>Auth::user()->branch
        );

        loan_provide::create($data);
        Toastr::success('Loan Provide Successfully', 'Success');
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
        $register = loan_register::get();
        $data = loan_provide::find($id);
        return view('inventory.loan_provide.edit',compact('register','data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = array(
            'date'=>$request->date,
            'register_id'=>$request->register_id,
            'amount'=>$request->amount,
            'note'=>$request->note,
            'branch'=>Auth::user()->branch
        );

        loan_provide::find($id)->update($data);
        Toastr::success('Loan Provide Update Successfully', 'Success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        loan_provide::find($id)->delete();
        Toastr::success('Loan Provide Delete Successfully', 'Success');
        return redirect()->back();
    }

    public function getloanRegisterBalance(Request $request)
    {
        $recived = loan_recived::where('register_id',$request->register_id)->sum('amount');

        $paid = loan_provide::where('register_id',$request->register_id)->sum('amount');

        $result = $recived - $paid;

        return $result;
    }

    public function retrive_loan_provide($id)
    {
        loan_provide::where('id',$id)->withTrashed()->restore();
        Toastr::success('Loan Provide Restore Successfully', 'Success');
        return redirect()->back();
    }
    public function delete_loan_provide($id)
    {
        loan_provide::where('id',$id)->withTrashed()->forceDelete();
        Toastr::success('Loan Provide Delete Successfully', 'Success');
        return redirect()->back();
    }
}
