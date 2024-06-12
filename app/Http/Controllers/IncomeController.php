<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use Auth;
use App\Models\income_entry;
use App\Models\income_expense_title;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = income_entry::leftjoin('income_expense_titles','income_expense_titles.id','income_entries.income_id')
            ->where('income_entries.branch',Auth::user()->branch)
            ->select('income_entries.*','income_expense_titles.title_en','income_expense_titles.title_bn')
            ->get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<div class="dropdown">
                    <a class="btn btn-secondary dropdown-toggle btn-sm" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a onclick="return Confirm()" class="dropdown-item" href="'.route('add_income.edit',$row->id).'"><i class="fa fa-edit"></i> Edit</a>
                        <form action="'.route('add_income.destroy',$row->id).'" method="post">
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

        return view('inventory.income.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $income = income_expense_title::where('type',1)->where('status',1)->get();
        return view('inventory.income.create',compact('income'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = array(
            'date'       => $request->date,
            'entry_date' => date("Y-m-d"),
            'income_id'  => $request->income_id,
            'amount'     => $request->amount,
            'note'       => $request->note,
            'branch'     => Auth()->user()->branch,
            'admin'      => Auth()->user()->id,

        );

          income_entry::insert($data);
          Toastr::success('Income Added', 'Success');
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
        $income = income_expense_title::where('type',1)->where('status',1)->get();
        $data = income_entry::find($id);
        return view('inventory.income.edit',compact('income','data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = array(
            'date'       => $request->date,
            'entry_date' => date("Y-m-d"),
            'income_id'  => $request->income_id,
            'amount'     => $request->amount,
            'note'       => $request->note,
            'branch'     => Auth()->user()->branch,
            'admin'      => Auth()->user()->id,

        );

          income_entry::find($id)->update($data);
          Toastr::success('Income Updated', 'Success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        income_entry::find($id)->delete();
        Toastr::success('Income Deleted', 'Success');
        return redirect()->back();
    }

    public function retrive_income($id)
    {
        income_entry::where('id',$id)->withTrashed()->restore();
        Toastr::success('Income Restored', 'Success');
        return redirect()->back();
    }

    public function income_per_delete($id)
    {
        income_entry::where('id',$id)->withTrashed()->forceDelete();
        Toastr::success('Income Permenantly Delted', 'Success');
        return redirect()->back();
    }
}
