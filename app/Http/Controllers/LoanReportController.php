<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\loan_register;
use App\Models\loan_recived;
use App\Models\loan_provide;

class LoanReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $member = loan_register::all();
        return view('inventory.loan_report.index',compact('member'));
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

    public function show_loan_report(Request $request)
    {
        if($request->register_id == 'All')
        {
            $report_type = $request->register_id;
            $from_date = $request->from_date;
            $to_date = $request->to_date;

            $loan_recived = loan_recived::whereBetween('loan_reciveds.date',[$request->from_date,$request->to_date])
            ->leftjoin('loan_registers','loan_registers.id','loan_reciveds.register_id')
            ->select('loan_reciveds.*','loan_registers.name')
            ->get();

            $total_loan_recived = loan_recived::whereBetween('loan_reciveds.date',[$request->from_date,$request->to_date])
            ->sum('amount');

            $loan_provide = loan_provide::whereBetween('loan_provides.date',[$request->from_date,$request->to_date])
            ->leftjoin('loan_registers','loan_registers.id','loan_provides.register_id')
            ->select('loan_provides.*','loan_registers.name')
            ->get();

            $total_loan_provide = loan_provide::whereBetween('loan_provides.date',[$request->from_date,$request->to_date])
            ->sum('amount');

            return view('inventory.loan_report.show_loan_report',compact('report_type','from_date','to_date','loan_recived','total_loan_recived','loan_provide','total_loan_provide'));
        }
        else
        {
            $report_type = $request->register_id;
            $from_date = $request->from_date;
            $to_date = $request->to_date;

            $member = loan_register::where('id',$request->register_id)->first();

            $loan_recived = loan_recived::whereBetween('loan_reciveds.date',[$request->from_date,$request->to_date])
            ->where('loan_reciveds.register_id',$request->register_id)
            ->leftjoin('loan_registers','loan_registers.id','loan_reciveds.register_id')
            ->select('loan_reciveds.*','loan_registers.name')
            ->get();

            $total_loan_recived = loan_recived::whereBetween('loan_reciveds.date',[$request->from_date,$request->to_date])
            ->where('loan_reciveds.register_id',$request->register_id)
            ->sum('loan_reciveds.amount');

            $loan_provide = loan_provide::whereBetween('loan_provides.date',[$request->from_date,$request->to_date])
            ->where('loan_provides.register_id',$request->register_id)
            ->leftjoin('loan_registers','loan_registers.id','loan_provides.register_id')
            ->select('loan_provides.*','loan_registers.name')
            ->get();

            $total_loan_provide = loan_provide::whereBetween('loan_provides.date',[$request->from_date,$request->to_date])
            ->where('loan_provides.register_id',$request->register_id)
            ->sum('loan_provides.amount');

            return view('inventory.loan_report.show_loan_report',compact('report_type','from_date','to_date','member','loan_recived','total_loan_recived','loan_provide','total_loan_provide'));
        }
    }
}
