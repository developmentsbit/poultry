<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use App\Models\product_information;
use App\Models\product_item;
use App\Models\product_category;
use App\Models\product_brand;
use App\Models\product_measurement;
use Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        if ($request->ajax()) {
            $data = product_information::join('product_items','product_items.item_id','=','product_informations.pdt_item_id')
            ->join('product_categories','product_categories.cat_id','=','product_informations.pdt_cat_id')
            ->join('product_brands','product_brands.brand_id','=','product_informations.pdt_brand_id')
            ->join('product_measurements','product_measurements.measurement_id','=','product_informations.pdt_measurement')
            ->select('product_informations.*','product_items.item_name_en','product_items.item_name_bn','product_categories.cat_name_en','product_categories.cat_name_bn','product_brands.brand_name_en','product_brands.brand_name_bn','product_measurements.measurement_unit')
            ->groupBy('product_informations.id')
            ->get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('product_information',function($row){
                return "<b>Item</b> : ".$row->item_name_en."<br>
                <b>Category</b> : ".$row->cat_name_en."<br>
                <b>Brand</b> : ".$row->brand_name_en."<br>
                <b>Measurement</b> : ".$row->measurement_unit."<br>";
            })
            ->addColumn('product_name',function($row){
                return "<span>".$row->pdt_name_en."</span><br>
                        <span>".$row->pdt_name_bn."</span>";
            })
            ->addColumn('status',function($row){
                if($row->pdt_status == 1)
                    {
                        $checked = 'checked';
                    }
                    else
                    {
                        $checked = '';
                    }

                    return '<input type="checkbox" id="statusChange('.$row->id.')" value="'.$row->id.'" data-switch="primary" onclick="return changeProductStatus('.$row->id.')" '.$checked.'>
                    <label for="statusChange('.$row->id.')"></label>';
            })
            ->addColumn('action', function($row){
                $btn = '<div class="dropdown">
                    <a class="btn btn-secondary dropdown-toggle btn-sm" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a onclick="return Confirm()" class="dropdown-item" href="'.route('product.edit',$row->pdt_id).'"><i class="fa fa-edit"></i> Edit</a>
                        <form action="'.route('product.destroy',$row->pdt_id).'" method="post">
                        '.csrf_field().'
                        '.method_field("DELETE").'
                        <button onclick="return Confirm()" type="submit" class="dropdown-item text-danger"><i class="fa fa-trash"></i> Delete</button>
                        </form>
                    </div>
                </div>';
                return $btn;
            })
            ->rawColumns(['action','product_information','status','product_name'])
            ->make(true);


        }
        return view('inventory.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $item = product_item::where('item_status',1)->get();
        $brand = product_brand::where('brand_status',1)->get();
        $measurement = product_measurement::get();
        return view('inventory.product.create',compact('item','brand','measurement'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $r)
    {
        $id = IdGenerator::generate(['table' => 'product_informations', 'field'=>'pdt_id','length' => 10, 'prefix' =>'PDT-']);

       $data = array(
        'pdt_id'             => $id,
        'pdt_item_id'        => $r->pdt_item_id,
        'barcode'            => $r->barcode,
        'pdt_cat_id'         => $r->pdt_cat_id,
        'pdt_brand_id'       => $r->pdt_brand_id,
        'pdt_name_en'        => $r->pdt_name_en,
        'pdt_name_bn'        => $r->pdt_name_bn,
        'pdt_measurement'    => $r->pdt_measurement,
        'pdt_purchase_price' => $r->pdt_purchase_price,
        'pdt_sale_price'     => $r->pdt_sale_price,
        'pdt_status'         => $r->pdt_status,
        'pdt_admin_id'       => Auth()->user()->id,
    );

       product_information::insert($data);
       Toastr::success('Product Added Successfully', 'Success');
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
        $data = product_information::where('pdt_id',$id)->first();
        $item = product_item::where('item_status',1)->get();
        $brand = product_brand::where('brand_status',1)->get();
        $measurement = product_measurement::get();
        $category = product_category::where('cat_item_id',$data->pdt_item_id)->get();
        return view('inventory.product.edit',compact('data','item','category','brand','measurement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $r, string $id)
    {
        $data = array(
            'pdt_item_id'        => $r->pdt_item_id,
            'pdt_cat_id'         => $r->pdt_cat_id,
            'pdt_brand_id'       => $r->pdt_brand_id,
            'pdt_name_en'        => $r->pdt_name_en,
            'pdt_name_bn'        => $r->pdt_name_bn,
            'pdt_measurement'    => $r->pdt_measurement,
            'pdt_purchase_price' => $r->pdt_purchase_price,
            'pdt_sale_price'     => $r->pdt_sale_price,
            'pdt_status'         => $r->pdt_status,
            'pdt_admin_id'       => Auth()->user()->id,
        );

           product_information::where('pdt_id',$id)->update($data);
           Toastr::success('Product Update Successfully', 'Success');
            return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        product_information::where('pdt_id',$id)->delete();
        Toastr::success('Product Delete Successfully', 'Success');
        return redirect()->back();
    }

    public function getcatajax($id)
    {
        $data = product_category::where('cat_status',1)->where('cat_item_id',$id)->get();
        foreach ($data as $d)
        {
            echo "<option value='$d->cat_id'>$d->cat_name_en ( $d->cat_name_bn )</option>";
        }
    }
    public function changeProductStatus(Request $request)
    {
        $find = product_information::find($request->id);

        if($find->pdt_status == 1)
        {
            product_information::find($request->id)->update(['pdt_status'=>0]);
        }
        else
        {
            product_information::find($request->id)->update(['pdt_status'=>1]);
        }

        return 1;
    }
    public function retrive_product($id)
    {
        product_information::where('pdt_id',$id)->restore();
        Toastr::success('Product Retrive Successfully', 'Success');
        return redirect()->back();
    }
    public function product_per_delete($id)
    {
        product_information::where('pdt_id',$id)->withTrashed()->forceDelete();
        Toastr::success('Product Permenantly Delete Successfully', 'Success');
        return redirect()->back();
    }
}
