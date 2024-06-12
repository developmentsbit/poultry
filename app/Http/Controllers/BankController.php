<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\bank_info;
use Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use DataTables;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = bank_info::where('bank_infos.branch_id',Auth::user()->branch)->get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<div class="dropdown">
                    <a class="btn btn-secondary dropdown-toggle btn-sm" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a onclick="return Confirm()" class="dropdown-item" href="'.route('add_bank.edit',$row->id).'"><i class="fa fa-edit"></i> Edit</a>
                        <form action="'.route('add_bank.destroy',$row->id).'" method="post">
                        '.csrf_field().'
                        '.method_field("DELETE").'
                        <button onclick="return Confirm()" type="submit" class="dropdown-item text-danger"><i class="fa fa-trash"></i> Delete</button>
                        </form>
                    </div>
                </div>';
                return $btn;
            })
            ->make(true);


        }
        return view('inventory.bank.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inventory.bank.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = array(
            'bank_name'     => $request->bank_name,
            'account_number'=> $request->account_number,
            'details'       => $request->details,
            'contact'       => $request->contact,
            'account_type'  => $request->account_type,
            'bankingType'   => $request->bankingType,
            'limit'         => $request->limit,
            'expiry'        => $request->expiry,
            'branch_id'     => Auth()->user()->branch,
            'admin'         => Auth()->user()->id,

        );

        bank_info::insert($data);
        Toastr::success('Bank Created', 'Success');
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
        $data = bank_info::find($id);
        return view('inventory.bank.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = array(
            'bank_name'     => $request->bank_name,
            'account_number'=> $request->account_number,
            'details'       => $request->details,
            'contact'       => $request->contact,
            'account_type'  => $request->account_type,
            'bankingType'   => $request->bankingType,
            'limit'         => $request->limit,
            'expiry'        => $request->expiry,
            'branch_id'     => Auth()->user()->branch,
            'admin'         => Auth()->user()->id,

        );

        bank_info::find($id)->update($data);
        Toastr::success('Bank Updated', 'Success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        bank_info::find($id)->delete();
        Toastr::success('Bank Deleted', 'Success');
        return redirect()->back();
    }

    public function retrive_bank($id)
    {
        bank_info::where('id',$id)->withTrashed()->restore();
        Toastr::success('Bank Restored', 'Success');
        return redirect()->back();
    }

    public function bank_per_delete($id)
    {
        bank_info::where('id',$id)->withTrashed()->forceDelete();
        Toastr::success('Bank Deleted', 'Success');
        return redirect()->back();
    }
}
