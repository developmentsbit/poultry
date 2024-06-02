<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use Auth;
use App\Models\income_expense_title;

class IncomeExpenseTitleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = income_expense_title::get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('type',function($row){
                if($row->type == 1)
                {
                    return 'Income';
                }
                else{
                    return 'Expense';
                }
            })
            ->addColumn('status',function($row){
                if($row->status == 1)
                    {
                        $checked = 'checked';
                    }
                    else
                    {
                        $checked = '';
                    }

                    return '<input type="checkbox" id="statusChange('.$row->id.')" value="'.$row->id.'" data-switch="primary" onclick="return changetTitleStatus('.$row->id.')" '.$checked.'>
                    <label for="statusChange('.$row->id.')"></label>';
            })
            ->addColumn('action', function($row){
                $btn = '<div class="dropdown">
                    <a class="btn btn-secondary dropdown-toggle btn-sm" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a onclick="return Confirm()" class="dropdown-item" href="'.route('income_expense_title.edit',$row->id).'"><i class="fa fa-edit"></i> Edit</a>
                        <form action="'.route('income_expense_title.destroy',$row->id).'" method="post">
                        '.csrf_field().'
                        '.method_field("DELETE").'
                        <button onclick="return Confirm()" type="submit" class="dropdown-item text-danger"><i class="fa fa-trash"></i> Delete</button>
                        </form>
                    </div>
                </div>';
                return $btn;
            })
            ->rawColumns(['action','type','status'])
            ->make(true);


        }
        return view('inventory.income_expense_title.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inventory.income_expense_title.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = array(
            'title_en'=>$request->title_en,
            'title_bn'=>$request->title_bn,
            'type'=>$request->type,
            'status'=>$request->status,
            'branch'=>Auth::user()->branch,
            'admin'=>Auth::user()->id,
        );

        income_expense_title::create($data);

        Toastr::success('Title Created', 'Success');
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
        $data = income_expense_title::find($id);
        return view('inventory.income_expense_title.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = array(
            'title_en'=>$request->title_en,
            'title_bn'=>$request->title_bn,
            'type'=>$request->type,
            'status'=>$request->status,
            'branch'=>Auth::user()->branch,
            'admin'=>Auth::user()->id,
        );

        income_expense_title::find($id)->update($data);

        Toastr::success('Title Updated', 'Success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        income_expense_title::find($id)->delete();
        Toastr::success('Title Deleted', 'Success');
        return redirect()->back();
    }

    public function retrive_title($id)
    {
        income_expense_title::where('id',$id)->withTrashed()->restore();
        Toastr::success('Title Restored', 'Success');
        return redirect()->back();
    }

    public function title_per_delete($id)
    {
        income_expense_title::where('id',$id)->withTrashed()->forceDelete();
        Toastr::success('Title Deleted', 'Success');
        return redirect()->back();
    }

    public function changetTitleStatus(Request $request)
    {
        $check = income_expense_title::find($request->id);

        if($check->status == 1)
        {
            income_expense_title::find($request->id)->update(['status'=>'0']);
        }
        else
        {
            income_expense_title::find($request->id)->update(['status'=>'1']);

        }
    }
}
