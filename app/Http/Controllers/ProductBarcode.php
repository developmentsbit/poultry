<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\product_information;
class ProductBarcode extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = product_information::where('pdt_status',1)->get();
        return view('inventory.product_barcode.index',compact('product'));
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
        // dd($request->all());

        $product_id = $request->product_id;

        if($product_id)
        {
            $data = product_information::whereIn('pdt_id',$product_id)->get();
        }
        else
        {
            return redirect()->back();
        }

        return view('inventory.product_barcode.show_barcode',compact('data'));
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

    public function generate_barcode(Reqeust $request)
    {

    }
}
