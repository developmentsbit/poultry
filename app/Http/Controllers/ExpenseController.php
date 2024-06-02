<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use Auth;
use App\Models\expense_entry;
use App\Models\income_expense_title;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = expense_entry::leftjoin('income_expense_titles','income_expense_titles.id','expense_entries.expense_id')
            ->select('expense_entries.*','income_expense_titles.title_en','income_expense_titles.title_bn')
            ->get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<div class="dropdown">
                    <a class="btn btn-secondary dropdown-toggle btn-sm" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a onclick="return Confirm()" class="dropdown-item" href="'.route('add_expense.edit',$row->id).'"><i class="fa fa-edit"></i> Edit</a>
                        <form action="'.route('add_expense.destroy',$row->id).'" method="post">
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

        return view('inventory.expense.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $expense = income_expense_title::where('type',2)->where('status',1)->get();
        return view('inventory.expense.create',compact('expense'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = array(
            'date'       => $request->date,
            'entry_date' => date("Y-m-d"),
            'expense_id'  => $request->expense_id,
            'amount'     => $request->amount,
            'note'       => $request->note,
            'branch'     => Auth()->user()->branch,
            'admin'      => Auth()->user()->id,

        );

          expense_entry::insert($data);
          Toastr::success('Expense Added', 'Success');
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
        $expense = income_expense_title::where('type',2)->where('status',1)->get();
        $data = expense_entry::find($id);
        return view('inventory.expense.edit',compact('expense','data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = array(
            'date'       => $request->date,
            'entry_date' => date("Y-m-d"),
            'expense_id'  => $request->expense_id,
            'amount'     => $request->amount,
            'note'       => $request->note,
            'branch'     => Auth()->user()->branch,
            'admin'      => Auth()->user()->id,

        );

          expense_entry::find($id)->update($data);
          Toastr::success('Expense Updated', 'Success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        expense_entry::find($id)->delete();
        Toastr::success('Expense Deleted', 'Success');
        return redirect()->back();
    }

    public function retrive_expense($id)
    {
        expense_entry::where('id',$id)->withTrashed()->restore();

        Toastr::success('Expense Restored', 'Success');
        return redirect()->back();
    }

    public function expense_per_delete($id)
    {
        expense_entry::where('id',$id)->withTrashed()->forceDelete();

        Toastr::success('Expense Deleted', 'Success');
        return redirect()->back();
    }
}
