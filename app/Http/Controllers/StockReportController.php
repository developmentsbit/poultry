<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\stock;
use App\Models\product_category;
use App\Models\product_brand;

class StockReportController extends Controller
{
    protected $path;
    public function __construct()
    {
        $this->path = 'inventory.report';
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = product_category::get();
        $brand = product_brand::all();
        return view($this->path.'.stock_report',compact('category','brand'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function show_stock_report(Request $request)
    {

        if($request->category_id == 'All' && $request->brand_id == 'All')
        {
            $data = stock::leftjoin('product_informations','product_informations.pdt_id','stocks.product_id')
            ->leftjoin('product_measurements','product_measurements.measurement_id','product_informations.pdt_measurement')
            ->select('stocks.*','product_informations.pdt_name_en','product_measurements.measurement_unit','product_informations.pdt_purchase_price')
            ->get();

            $category = $request->category_id;
            $brand = $request->brand_id;
        }
        elseif($request->category_id != 'All' && $request->brand_id != 'All')
        {
            $data = stock::leftjoin('product_informations','product_informations.pdt_id','stocks.product_id')
            ->leftjoin('product_measurements','product_measurements.measurement_id','product_informations.pdt_measurement')
            ->where('product_informations.pdt_cat_id',$request->category_id)
            ->orWhere('product_informations.pdt_brand_id',$request->brand_id)
            ->select('stocks.*','product_informations.pdt_name_en','product_measurements.measurement_unit','product_informations.pdt_purchase_price')
            ->get();
            $cat_name = product_category::where('cat_id',$request->category_id)->first();
            $brand_name = product_brand::where('brand_id',$request->brand_id)->first();
            $category = $cat_name->cat_name_en;
            $brand = $brand_name->brand_name_en;
        }
        elseif($request->category_id != 'All')
        {
            $data = stock::leftjoin('product_informations','product_informations.pdt_id','stocks.product_id')
            ->leftjoin('product_measurements','product_measurements.measurement_id','product_informations.pdt_measurement')
            ->where('product_informations.pdt_cat_id',$request->category_id)
            ->select('stocks.*','product_informations.pdt_name_en','product_measurements.measurement_unit','product_informations.pdt_purchase_price')
            ->get();
            $cat_name = product_category::where('cat_id',$request->category_id)->first();
            $category = $cat_name->cat_name_en;
            $brand = $request->brand_id;
        }
        else
        {
            $data = stock::leftjoin('product_informations','product_informations.pdt_id','stocks.product_id')
            ->leftjoin('product_measurements','product_measurements.measurement_id','product_informations.pdt_measurement')
            ->where('product_informations.pdt_brand_id',$request->brand_id)
            ->select('stocks.*','product_informations.pdt_name_en','product_measurements.measurement_unit','product_informations.pdt_purchase_price')
            ->get();
            $brand_name = product_brand::where('brand_id',$request->brand_id)->first();
            $brand = $brand_name->brand_name_en;
            $category = $request->category_id;
        }


        return view($this->path.'.show_report',compact('data','category','brand'));
    }
}
