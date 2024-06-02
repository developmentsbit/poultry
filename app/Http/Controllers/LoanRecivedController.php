<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use Auth;
use App\Models\loan_register;
use App\Models\loan_recived;

class LoanRecivedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = loan_recived::leftjoin('loan_registers','loan_registers.id','loan_reciveds.register_id')
            ->select('loan_reciveds.*','loan_registers.name')
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
                        <a onclick="return Confirm()" class="dropdown-item" href="'.route('loan_recived.edit',$row->id).'"><i class="fa fa-edit"></i> Edit</a>
                        <form action="'.route('loan_recived.destroy',$row->id).'" method="post">
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

        return view('inventory.loan_recived.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $register = loan_register::get();
        return view('inventory.loan_recived.create',compact('register'));
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

        loan_recived::create($data);
        Toastr::success('Loan Recived Successfully', 'Success');
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
        $data = loan_recived::find($id);
        return view('inventory.loan_recived.edit',compact('register','data'));
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

        loan_recived::find($id)->update($data);
        Toastr::success('Loan Recived Update Successfully', 'Success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        loan_recived::find($id)->delete();
        Toastr::success('Loan Recived Delete Successfully', 'Success');
        return redirect()->back();
    }

    public function retrive_loan_recived($id)
    {
        loan_recived::where('id',$id)->withTrashed()->restore();
        Toastr::success('Loan Recived Restore Successfully', 'Success');
        return redirect()->back();
    }
    public function delete_loan_recived($id)
    {
        loan_recived::where('id',$id)->withTrashed()->forceDelete();
        Toastr::success('Loan Recived Delete Successfully', 'Success');
        return redirect()->back();
    }
}
