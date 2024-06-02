<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use App\Models\product_category;
use App\Models\product_item;
use Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = product_category::leftjoin('product_items','product_items.item_id','product_categories.cat_item_id')
            ->select('product_categories.*','product_items.item_name_en','product_items.item_name_bn')
            ->get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('item_name',function($row){
                return '<b>'.$row->item_name_en.'</b><br>
                <span>'.$row->item_name_bn.'</span><br>';
            })
            ->addColumn('category_name',function($row){
                return '<b>'.$row->cat_name_en.'</b><br>
                <span>'.$row->cat_name_bn.'</span><br>';
            })
            ->addColumn('status',function($row){
                if($row->cat_status == 1)
                    {
                        $checked = 'checked';
                    }
                    else
                    {
                        $checked = '';
                    }

                    return '<input type="checkbox" id="statusChange('.$row->id.')" value="'.$row->id.'" data-switch="primary" onclick="return changeCatStatus('.$row->id.')" '.$checked.'>
                    <label for="statusChange('.$row->id.')"></label>';
            })
            ->addColumn('action', function($row){
                $btn = '<div class="dropdown">
                    <a class="btn btn-secondary dropdown-toggle btn-sm" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a onclick="return Confirm()" class="dropdown-item" href="'.route('category.edit',$row->cat_id).'"><i class="fa fa-edit"></i> Edit</a>
                        <form action="'.route('category.destroy',$row->cat_id).'" method="post">
                        '.csrf_field().'
                        '.method_field("DELETE").'
                        <button onclick="return Confirm()" type="submit" class="dropdown-item text-danger"><i class="fa fa-trash"></i> Delete</button>
                        </form>
                    </div>
                </div>';
                return $btn;
            })
            ->rawColumns(['action','category_name','status','item_name'])
            ->make(true);


        }
        return view('inventory.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $item = product_item::where('item_status',1)->get();
        return view('inventory.category.create',compact('item'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $r)
    {
        $id = IdGenerator::generate(['table' => 'product_categories', 'field'=>'cat_id','length' => 10, 'prefix' =>'CAT-']);


     $data = array(
        'cat_id'         => $id,
        'cat_item_id'    => $r->cat_item_id,
        'cat_name_en'    => $r->cat_name_en,
        'cat_name_bn'    => $r->cat_name_bn,
        'cat_status'     => $r->cat_status,
        'cat_admin_id'   => Auth()->user()->id,

    );

     product_category::insert($data);
     Toastr::success('Categorey Create Successfullly', 'Success');
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
        $data = product_category::where('cat_id',$id)->first();
        $item = product_item::where('item_status',1)->get();
        return view('inventory.category.edit',compact('item','data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $r, string $id)
    {
        $data = array(
            'cat_item_id'    => $r->cat_item_id,
            'cat_name_en'    => $r->cat_name_en,
            'cat_name_bn'    => $r->cat_name_bn,
            'cat_status'     => $r->cat_status,
            'cat_admin_id'   => Auth()->user()->id,

        );

         product_category::where('cat_id',$id)->update($data);
         Toastr::success('Categorey Update Successfullly', 'Success');
         return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        product_category::where('cat_id',$id)->delete();
        Toastr::success('Categorey Delete Successfullly', 'Success');
         return redirect()->back();
    }

    public function changeCatStatus(Request $request)
    {
        $find = product_category::find($request->id);

        if($find->cat_status == 1)
        {
            product_category::find($request->id)->update(['cat_status'=>0]);
        }
        else
        {
            product_category::find($request->id)->update(['cat_status'=>1]);
        }

        return 1;
    }

    public function retrive_category($id)
    {
        product_category::where('cat_id',$id)->restore();

        Toastr::success('Categorey Restore Successfullly', 'Success');
         return redirect()->back();
    }

    public function catper_delete($id)
    {
        product_category::where('cat_id',$id)->withTrashed()->forceDelete();
        Toastr::success('Categorey Permenantly Delete Successfullly', 'Success');
         return redirect()->back();
    }
}
