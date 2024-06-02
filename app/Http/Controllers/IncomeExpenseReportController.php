<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\income_entry;
use App\Models\expense_entry;
use App\Models\income_expense_title;

class IncomeExpenseReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('inventory.income_expense_report.index');
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

    public function show_income_expense_report(Request $request)
    {
        if($request->report_type == 'all')
        {
            $incomes = income_entry::leftjoin('income_expense_titles','income_expense_titles.id','income_entries.income_id')
                        ->whereBetween('income_entries.date',[$request->from_date,$request->to_date])
                        ->select('income_expense_titles.title_en','income_entries.*')
                        ->get();

            $expense = expense_entry::leftjoin('income_expense_titles','income_expense_titles.id','expense_entries.expense_id')
            ->whereBetween('expense_entries.date',[$request->from_date,$request->to_date])
            ->select('income_expense_titles.title_en','expense_entries.*')
            ->get();

            $total_income = income_entry::whereBetween('income_entries.date',[$request->from_date,$request->to_date])
            ->sum('amount');
            $total_expense = expense_entry::whereBetween('expense_entries.date',[$request->from_date,$request->to_date])
            ->sum('amount');

            $from_date = $request->from_date;
            $to_date = $request->to_date;
            $report_type = $request->report_type;

            $i = 1;
            return view('inventory.income_expense_report.show_income_expense_report',compact('incomes','expense','i','total_income','total_expense','from_date','to_date','report_type'));
        }
        elseif($request->report_type == 'income')
        {
            $incomes = income_entry::leftjoin('income_expense_titles','income_expense_titles.id','income_entries.income_id')
            ->whereBetween('income_entries.date',[$request->from_date,$request->to_date])
            ->select('income_expense_titles.title_en','income_entries.*')
            ->get();

            $total_income = income_entry::whereBetween('income_entries.date',[$request->from_date,$request->to_date])
            ->sum('amount');

            $from_date = $request->from_date;
            $to_date = $request->to_date;
            $report_type = $request->report_type;

            $i = 1;
            return view('inventory.income_expense_report.show_income_expense_report',compact('incomes','i','total_income','from_date','to_date','report_type'));
        }
        elseif($request->report_type == 'expense')
        {
            $expense = expense_entry::leftjoin('income_expense_titles','income_expense_titles.id','expense_entries.expense_id')
            ->whereBetween('expense_entries.date',[$request->from_date,$request->to_date])
            ->select('income_expense_titles.title_en','expense_entries.*')
            ->get();

            $total_expense = expense_entry::whereBetween('expense_entries.date',[$request->from_date,$request->to_date])
            ->sum('amount');

            $from_date = $request->from_date;
            $to_date = $request->to_date;
            $report_type = $request->report_type;

            $i = 1;

            return view('inventory.income_expense_report.show_income_expense_report',compact('expense','i','total_expense','from_date','to_date','report_type'));
        }
    }
}
