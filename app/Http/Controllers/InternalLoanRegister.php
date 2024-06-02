<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use Auth;
use App\Models\internal_loan_register;

class InternalLoanRegister extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = internal_loan_register::get();
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
                        <a onclick="return Confirm()" class="dropdown-item" href="'.route('internal_loanregister.edit',$row->id).'"><i class="fa fa-edit"></i> Edit</a>
                        <form action="'.route('internal_loanregister.destroy',$row->id).'" method="post">
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
        return view('inventory.internal_loan_register.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inventory.internal_loan_register.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = array(
            'name'=>$request->name,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'admin'=>Auth::user()->id,
            'branch'=>Auth::user()->branch,
        );

        internal_loan_register::create($data);
        Toastr::success('Internal Loan Registraion Successfully', 'Success');
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
        $data = internal_loan_register::find($id);
        return view('inventory.internal_loan_register.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = array(
            'name'=>$request->name,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'admin'=>Auth::user()->id,
            'branch'=>Auth::user()->branch,
        );

        internal_loan_register::find($id)->update($data);
        Toastr::success('Internal Loan Registraion Updated', 'Success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        internal_loan_register::find($id)->delete();
        Toastr::success('Internal Loan Registraion Deleted', 'Success');
        return redirect()->back();
    }

    public function retrive_internalloan_register($id)
    {
        internal_loan_register::where('id',$id)->withTrashed()->restore();
        Toastr::success('Internal Loan Registraion Restored', 'Success');
        return redirect()->back();
    }

    public function delete_internalloan_register($id)
    {
        internal_loan_register::where('id',$id)->withTrashed()->forceDelete();
        Toastr::success('Internal Loan Registraion Deleted', 'Success');
        return redirect()->back();
    }
}
