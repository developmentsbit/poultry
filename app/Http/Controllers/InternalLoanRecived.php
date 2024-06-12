<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use Auth;
use App\Models\internal_loan_recived;
use App\Models\internal_loan_provide;
use App\Models\internal_loan_register;

class InternalLoanRecived extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = internal_loan_recived::leftjoin('internal_loan_registers','internal_loan_registers.id','internal_loan_reciveds.register_id')
            ->where('internal_loan_reciveds.branch',Auth::user()->branch)
            ->select('internal_loan_reciveds.*','internal_loan_registers.name')
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
                        <a onclick="return Confirm()" class="dropdown-item" href="'.route('internal_loan_recived.edit',$row->id).'"><i class="fa fa-edit"></i> Edit</a>
                        <form action="'.route('internal_loan_recived.destroy',$row->id).'" method="post">
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
        return view('inventory.internal_loan_recived.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $register = internal_loan_register::get();
        return view('inventory.internal_loan_recived.create',compact('register'));
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

        internal_loan_recived::create($data);
        Toastr::success('Internal Loan Recived Successfully', 'Success');
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
        $register = internal_loan_register::get();
        $data = internal_loan_recived::find($id);
        return view('inventory.internal_loan_recived.edit',compact('register','data'));
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

        internal_loan_recived::find($id)->update($data);
        Toastr::success('Internal Loan Recived Update Successfully', 'Success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        internal_loan_recived::find($id)->delete();
        Toastr::success('Internal Loan Recived Delete Successfully', 'Success');
        return redirect()->back();
    }

    public function getintloanRegisterdue_loan(Request $request)
    {
        $recived = internal_loan_recived::where('register_id',$request->register_id)->sum('amount');

        $provide = internal_loan_provide::where('register_id',$request->register_id)->sum('amount');

        $result = $provide - $recived;

        return $result;
    }

    public function retrive_intloan_recived($id)
    {
        internal_loan_recived::where('id',$id)->restore();
        Toastr::success('Internal Loan Recived Restore Successfully', 'Success');
        return redirect()->back();
    }
    public function delete_intloan_recived($id)
    {
        internal_loan_recived::where('id',$id)->onlyTrashed()->forceDelete();
        Toastr::success('Internal Loan Recived Delete Successfully', 'Success');
        return redirect()->back();
    }
}
