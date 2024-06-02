<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\stock;
use DataTables;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = stock::leftjoin('product_informations','product_informations.pdt_id','stocks.product_id')
            ->select('stocks.*','product_informations.pdt_name_en')
            ->get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('product_name',function($row){
                return $row->product_id.' - '.$row->pdt_name_en;
            })
            ->addColumn('available_quantity',function($row){
                return '<span class="badge bg-success">'.( $row->quantity - $row->purchase_return_qty) - ($row->sales_qty - $row->sales_return_qty).'</span>';
            })
            ->rawColumns(['available_quantity'])
            ->make(true);

        }
        return view('inventory.stock.index');
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

    public function full_stock_report()
    {
        $data = stock::leftjoin('product_informations','product_informations.pdt_id','stocks.product_id')
        ->leftjoin('product_measurements','product_measurements.measurement_id','product_informations.pdt_measurement')
        ->select('product_informations.pdt_name_en','stocks.*','product_measurements.measurement_unit')
        ->get();
        return view('inventory.stock.full_report',compact('data'));
    }
}
