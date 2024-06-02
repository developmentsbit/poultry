<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\internal_loan_register;
use App\Models\internal_loan_recived;
use App\Models\internal_loan_provide;

class InternalLoanReport extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $member = internal_loan_register::all();
        return view('inventory.internal_loan_report.index',compact('member'));
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

    public function show_internal_loan_report(Request $request)
    {
        if($request->register_id == 'All')
        {
            $report_type = $request->register_id;
            $from_date = $request->from_date;
            $to_date = $request->to_date;

            $loan_recived = internal_loan_recived::whereBetween('internal_loan_reciveds.date',[$request->from_date,$request->to_date])
            ->leftjoin('internal_loan_registers','internal_loan_registers.id','internal_loan_reciveds.register_id')
            ->select('internal_loan_reciveds.*','internal_loan_registers.name')
            ->get();

            $total_loan_recived = internal_loan_recived::whereBetween('internal_loan_reciveds.date',[$request->from_date,$request->to_date])
            ->sum('amount');

            $loan_provide = internal_loan_provide::whereBetween('internal_loan_provides.date',[$request->from_date,$request->to_date])
            ->leftjoin('internal_loan_registers','internal_loan_registers.id','internal_loan_provides.register_id')
            ->select('internal_loan_provides.*','internal_loan_registers.name')
            ->get();

            $total_loan_provide = internal_loan_provide::whereBetween('internal_loan_provides.date',[$request->from_date,$request->to_date])
            ->sum('amount');

            return view('inventory.internal_loan_report.show_report',compact('report_type','from_date','to_date','loan_recived','total_loan_recived','loan_provide','total_loan_provide'));
        }
        else
        {
            $report_type = $request->register_id;
            $from_date = $request->from_date;
            $to_date = $request->to_date;

            $member = internal_loan_register::where('id',$request->register_id)->first();

            $loan_recived = internal_loan_recived::whereBetween('internal_loan_reciveds.date',[$request->from_date,$request->to_date])
            ->where('internal_loan_reciveds.register_id',$request->register_id)
            ->leftjoin('internal_loan_registers','internal_loan_registers.id','internal_loan_reciveds.register_id')
            ->select('internal_loan_reciveds.*','internal_loan_registers.name')
            ->get();

            $total_loan_recived = internal_loan_recived::whereBetween('internal_loan_reciveds.date',[$request->from_date,$request->to_date])
            ->where('internal_loan_reciveds.register_id',$request->register_id)
            ->sum('internal_loan_reciveds.amount');

            $loan_provide = internal_loan_provide::whereBetween('internal_loan_provides.date',[$request->from_date,$request->to_date])
            ->where('internal_loan_provides.register_id',$request->register_id)
            ->leftjoin('internal_loan_registers','internal_loan_registers.id','internal_loan_provides.register_id')
            ->select('internal_loan_provides.*','internal_loan_registers.name')
            ->get();

            $total_loan_provide = internal_loan_provide::whereBetween('internal_loan_provides.date',[$request->from_date,$request->to_date])
            ->where('internal_loan_provides.register_id',$request->register_id)
            ->sum('internal_loan_provides.amount');

            return view('inventory.internal_loan_report.show_report',compact('report_type','from_date','to_date','member','loan_recived','total_loan_recived','loan_provide','total_loan_provide'));
        }
    }
}
