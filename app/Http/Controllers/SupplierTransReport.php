<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\supplier_info;
use App\Models\supplier_payment;
use App\Models\purchase_ledger;

class SupplierTransReport extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $supplier = supplier_info::all();
        return view('inventory.supplier_trans_report.index',compact('supplier'));
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

    public function show_supplier_trans_report(Request $request)
    {
        $explode = explode('-',$request->from_date);

        $month = $explode['1'];
        $year = $explode['0'];
        $date = $explode['2'];

        $previous_date = date('Y-m-d', mktime(0,0,0,$month,($date-1),$year));

        $calculate_date = '2000-01-01';

        $previous_due = supplier_payment::where('supplier_id',$request->supplier_id)->where('comment','PD')->sum('previous_due');

        $total = purchase_ledger::where('suplier_id',$request->supplier_id)->whereBetween('invoice_date',[$calculate_date,$previous_date])->sum('total');

        $final_discount = purchase_ledger::where('suplier_id',$request->supplier_id)->whereBetween('invoice_date',[$calculate_date,$previous_date])->sum('discount');

        $payment = supplier_payment::whereBetween('payment_date',[$calculate_date,$previous_date])->where('supplier_id',$request->supplier_id)->where('payment','!=',NULL)->sum('payment');


        $return_amount = supplier_payment::whereBetween('payment_date',[$calculate_date,$previous_date])->where('supplier_id',$request->supplier_id)->sum('return_amount');

        // $returnpaid = supplier_payment::whereBetween('payment_date',[$calculate_date,$previous_date])->where('supplier_id',$request->supplier_id)->sum('returnpaid');

        $check_balnce = ($total - $final_discount) - $payment - $return_amount + $previous_due;

        if($check_balnce < 0)
        {
            $balance = 0;
        }
        else
        {
            $balance = $check_balnce;
        }


        // return $request->all();


        $from_date = $request->from_date;
        $to_date = $request->to_date;

        $supplier = supplier_info::where('supplier_id',$request->supplier_id)->first();


        $data = supplier_payment::where('supplier_id',$request->supplier_id)->whereBetween('payment_date',[$from_date,$to_date])->get();

        $total_purchase = purchase_ledger::where('suplier_id',$request->supplier_id)->whereBetween('invoice_date',[$from_date,$to_date])->sum('total');

        $total_discount = purchase_ledger::where('suplier_id',$request->supplier_id)->whereBetween('invoice_date',[$from_date,$to_date])->sum('discount');

        $total_paid = supplier_payment::where('supplier_id',$request->supplier_id)->whereBetween('payment_date',[$from_date,$to_date])->sum('payment');

        $total_return = supplier_payment::where('supplier_id',$request->supplier_id)->where('return_amount','!=',NULL)->whereBetween('payment_date',[$from_date,$to_date])->sum('return_amount');

        $discount = supplier_payment::where('supplier_id',$request->supplier_id)->whereBetween('payment_date',[$from_date,$to_date])->sum('discount');

        // return $discount;

        $totalDueBetweenSearch = (($total_purchase - $total_paid - $discount) - $total_return + $previous_due) - $total_discount;


        return view('inventory.supplier_trans_report.show_report',compact('supplier','from_date','to_date','previous_date','balance','data','previous_due','totalDueBetweenSearch'));
    }
}
