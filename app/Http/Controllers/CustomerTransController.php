<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\customer_info;
use App\Models\sales_payment;
use App\Models\sales_ledger;
use Carbon\Carbon;

class CustomerTransController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customer = customer_info::get();
        return view('inventory.customer_trans_report.index',compact('customer'));
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

    public function show_customer_trans_report(Request $request)
    {
        $explode = explode('-',$request->from_date);

        $month = $explode['1'];
        $year = $explode['0'];
        $date = $explode['2'];

        $previous_date = date('Y-m-d', mktime(0,0,0,$month,($date-1),$year));

        $calculate_date = '2000-01-01';

        $previous_due = sales_payment::where('customer_id',$request->customer_id)->where('note','PD')->sum('previous_due');

        $total = sales_ledger::where('customer_id',$request->customer_id)->whereBetween('invoice_date',[$calculate_date,$previous_date])->sum('total');

        $final_discount = sales_ledger::where('customer_id',$request->customer_id)->whereBetween('invoice_date',[$calculate_date,$previous_date])->sum('final_discount');

        $payment = sales_payment::whereBetween('entry_date',[$calculate_date,$previous_date])->where('customer_id',$request->customer_id)->where('payment_amount','!=',NULL)->sum('payment_amount');


        $return_amount = sales_payment::whereBetween('entry_date',[$calculate_date,$previous_date])->where('customer_id',$request->customer_id)->sum('return_amount');

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

        $customer = customer_info::where('customer_id',$request->customer_id)->first();

        // return $request->customer_id;
        $data = sales_payment::whereBetween('entry_date',[$from_date,$to_date])
        ->where('customer_id',$request->customer_id)
        ->get();

        // return $data;

        $total_purchase = sales_ledger::where('customer_id',$request->customer_id)->whereBetween('invoice_date',[$from_date,$to_date])->sum('total');
        $total_discount = sales_ledger::where('customer_id',$request->customer_id)->whereBetween('invoice_date',[$from_date,$to_date])->sum('final_discount');

        $total_paid = sales_payment::where('customer_id',$request->customer_id)->whereBetween('entry_date',[$from_date,$to_date])->sum('payment_amount');

        $total_return = sales_payment::where('customer_id',$request->customer_id)->where('return_amount','!=',NULL)->whereBetween('entry_date',[$from_date,$to_date])->sum('return_amount');

        $sales_payment_discount = sales_payment::where('customer_id',$request->customer_id)->whereBetween('entry_date',[$from_date,$to_date])->sum('discount');

        $totalDueBetweenSearch = (($total_purchase - ($total_paid + $sales_payment_discount)) - $total_return + $previous_due) - $total_discount;

        // return $totalDueBetweenSearch;

        return view('inventory.customer_trans_report.show_report',compact('customer','from_date','to_date','previous_date','balance','data','previous_due','totalDueBetweenSearch'));
    }
}
