<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use Auth;
use App\Models\internal_loan_provide;
use App\Models\internal_loan_recived;
use App\Models\internal_loan_register;

class InternalLoanProvide extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = internal_loan_provide::leftjoin('internal_loan_registers','internal_loan_registers.id','internal_loan_provides.register_id')
            ->select('internal_loan_provides.*','internal_loan_registers.name')
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
                        <a onclick="return Confirm()" class="dropdown-item" href="'.route('internal_loan_provide.edit',$row->id).'"><i class="fa fa-edit"></i> Edit</a>
                        <form action="'.route('internal_loan_provide.destroy',$row->id).'" method="post">
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
        return view('inventory.internal_loan_provide.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $register = internal_loan_register::get();
        return view('inventory.internal_loan_provide.create',compact('register'));
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

        internal_loan_provide::create($data);
        Toastr::success('Internal Loan Provide Successfully', 'Success');
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
        $data = internal_loan_provide::find($id);
        return view('inventory.internal_loan_provide.edit',compact('register','data'));
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

        internal_loan_provide::find($id)->update($data);
        Toastr::success('Internal Loan Provide Update Successfully', 'Success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        internal_loan_provide::find($id)->delete();
        Toastr::success('Internal Loan Provide Delete Successfully', 'Success');
        return redirect()->back();
    }

    public function retrive_intloan_provide($id)
    {
        internal_loan_provide::where('id',$id)->restore();
        Toastr::success('Internal Loan Provide Restored Successfully', 'Success');
        return redirect()->back();
    }
    public function delete_intloan_provide($id)
    {
        internal_loan_provide::where('id',$id)->withTrashed()->forceDelete();
        Toastr::success('Internal Loan Provide Delete Successfully', 'Success');
        return redirect()->back();
    }
}
