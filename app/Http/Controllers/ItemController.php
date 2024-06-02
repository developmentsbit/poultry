<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use App\Models\product_item;
use Auth;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = product_item::get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('item_name',function($row){
                return '<b>'.$row->item_name_en.'</b><br>
                <span>'.$row->item_name_bn.'</span><br>';
            })
            ->addColumn('status',function($row){
                if($row->item_status == 1)
                    {
                        $checked = 'checked';
                    }
                    else
                    {
                        $checked = '';
                    }

                    return '<input type="checkbox" id="statusChange('.$row->id.')" value="'.$row->id.'" data-switch="primary" onclick="return changeItemStatus('.$row->id.')" '.$checked.'>
                    <label for="statusChange('.$row->id.')"></label>';
            })
            ->addColumn('action', function($row){
                $btn = '<div class="dropdown">
                    <a class="btn btn-secondary dropdown-toggle btn-sm" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a onclick="return Confirm()" class="dropdown-item" href="'.route('item.edit',$row->item_id).'"><i class="fa fa-edit"></i> Edit</a>
                        <form action="'.route('item.destroy',$row->item_id).'" method="post">
                        '.csrf_field().'
                        '.method_field("DELETE").'
                        <button onclick="return Confirm()" type="submit" class="dropdown-item text-danger"><i class="fa fa-trash"></i> Delete</button>
                        </form>
                    </div>
                </div>';
                return $btn;
            })
            ->rawColumns(['action','item_name','status'])
            ->make(true);


        }
        return view('inventory.item.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inventory.item.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $r)
    {
        $id = IdGenerator::generate(['table' => 'product_items', 'field'=>'item_id','length' => 10, 'prefix' =>'ITM-']);


        $data = array(
            'item_id'         => $id,
            'item_name_en'    => $r->item_name_en,
            'item_name_bn'    => $r->item_name_bn,
            'item_status'     => $r->item_status,
            'item_admin_id'   => Auth()->user()->id,

        );

        product_item::insert($data);
        Toastr::success('Item Create Successfullly', 'Success');
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
        $data = product_item::where('item_id',$id)->first();
        return view('inventory.item.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $r, string $id)
    {
        $data = array(
            'item_name_en'    => $r->item_name_en,
            'item_name_bn'    => $r->item_name_bn,
            'item_status'     => $r->item_status,
            'item_admin_id'   => Auth()->user()->id,
        );

        product_item::where('item_id',$id)->update($data);
        Toastr::success('Item Update Successfullly', 'Success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        product_item::where('item_id',$id)->delete();
        Toastr::success('Item Delete Successfullly', 'Success');
        return redirect()->back();
    }

    public function changeItemStatus(Request $request)
    {
        // return $request->id;
        $find = product_item::find($request->id);

        if($find->item_status == 1)
        {
            product_item::find($request->id)->update(['item_status'=>0]);
        }
        else
        {
            product_item::find($request->id)->update(['item_status'=>1]);
        }

        return 1;
    }

    public function retrive_item($id)
    {
        product_item::where('item_id',$id)->restore();
        Toastr::success('Item Restore Successfullly', 'Success');
        return redirect()->back();
    }

    public function itemper_delete($id)
    {
        product_item::where('item_id',$id)->withTrashed()->forceDelete();
        Toastr::success('Item Permenantly Delete Successfullly', 'Success');
        return redirect()->back();
    }
}
