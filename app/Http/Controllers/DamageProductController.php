<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product_information;
use App\Models\stock;
use Brian2694\Toastr\Facades\Toastr;
use Auth;

class DamageProductController extends Controller
{
    protected $path;
    public function __construct()
    {
        $this->path = 'inventory.damage_product';
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = stock::where('damage_product','>',0)
        ->join('product_informations','product_informations.pdt_id','stocks.product_id')
        ->where('stocks.branch_id',Auth::user()->branch)
        ->select('product_informations.pdt_name_en','product_informations.pdt_name_bn','stocks.*')
        ->get();
        return view($this->path.'.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $product = product_information::get();
        return view($this->path.'.create',compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $prev = stock::where('product_id',$request->product_id)->where('branch_id',Auth::user()->branch)->first();
        if($prev)
        {
            stock::where('product_id',$request->product_id)->where('branch_id',Auth::user()->branch)->update([
                'damage_product' => $request->damage_product + $prev->damage_product,
            ]);
        }

        Toastr::success('Damage Stock Created', 'Success');
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

    public function getOriginalQty(Request $request)
    {
        $stock = stock::where('product_id',$request->product_id)->where('branch_id',Auth::user()->branch)->first();
        if($stock)
        {

            $result = ($stock->quantity + $stock->sales_return_qty) - ($stock->sales_qty + $stock->purchase_return_qty);

            $final_result = $result - $stock->damage_product;
            return $final_result;
        }
        else
        {
            return 0;
        }
    }
}
