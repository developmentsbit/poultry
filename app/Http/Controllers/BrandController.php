<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use Auth;
use App\Models\product_brand;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = product_brand::get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('brand_name',function($row){
                return '<b>'.$row->brand_name_en.'</b><br>
                <span>'.$row->brand_name_bn.'</span><br>';
            })
            ->addColumn('status',function($row){
                if($row->brand_status == 1)
                    {
                        $checked = 'checked';
                    }
                    else
                    {
                        $checked = '';
                    }

                    return '<input type="checkbox" id="statusChange('.$row->id.')" value="'.$row->id.'" data-switch="primary" onclick="return changeBrandStatus('.$row->id.')" '.$checked.'>
                    <label for="statusChange('.$row->id.')"></label>';
            })
            ->addColumn('action', function($row){
                $btn = '<div class="dropdown">
                    <a class="btn btn-secondary dropdown-toggle btn-sm" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a onclick="return Confirm()" class="dropdown-item" href="'.route('brand.edit',$row->brand_id).'"><i class="fa fa-edit"></i> Edit</a>
                        <form action="'.route('brand.destroy',$row->brand_id).'" method="post">
                        '.csrf_field().'
                        '.method_field("DELETE").'
                        <button onclick="return Confirm()" type="submit" class="dropdown-item text-danger"><i class="fa fa-trash"></i> Delete</button>
                        </form>
                    </div>
                </div>';
                return $btn;
            })
            ->rawColumns(['action','brand_name','status'])
            ->make(true);


        }
        return view('inventory.brand.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inventory.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $r)
    {
        $id = IdGenerator::generate(['table' => 'product_brands', 'field'=>'brand_id','length' => 10, 'prefix' =>'BRN-']);


        $data = array(
            'brand_id'        => $id,
            'brand_name_en'    => $r->brand_name_en,
            'brand_name_bn'    => $r->brand_name_bn,
            'brand_status'     => $r->brand_status,
            'brand_admin_id'   => Auth()->user()->id,

        );

        product_brand::create($data);
        Toastr::success('Brand Created Successfully', 'Success');
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
        $data = product_brand::where('brand_id',$id)->first();
        return view('inventory.brand.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $r, string $id)
    {
        $data = array(
            'brand_name_en'    => $r->brand_name_en,
            'brand_name_bn'    => $r->brand_name_bn,
            'brand_status'     => $r->brand_status,
            'brand_admin_id'   => Auth()->user()->id,

        );

        product_brand::where('brand_id',$id)->update($data);
        Toastr::success('Brand Update Successfully', 'Success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        product_brand::where('brand_id',$id)->delete();
        Toastr::success('Brand Delete Successfully', 'Success');
        return redirect()->back();
    }


    public function changeBrandStatus(Request $request)
    {
        $find = product_brand::find($request->id);

        if($find->brand_status == 1)
        {
            product_brand::find($request->id)->update(['brand_status'=>0]);
        }
        else
        {
            product_brand::find($request->id)->update(['brand_status'=>1]);
        }

        return 1;
    }

    public function retrive_brand($id)
    {
        product_brand::where('brand_id',$id)->restore();
        Toastr::success('Brand Retrive Successfully', 'Success');
        return redirect()->back();
    }

    public function brandper_delete($id)
    {
        product_brand::where('brand_id',$id)->withTrashed()->forceDelete();

        Toastr::success('Brand Permanantly Delete Successfully', 'Success');
        return redirect()->back();
    }
}
