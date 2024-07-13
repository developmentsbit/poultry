<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\sales_ledger;
use App\Models\sales_payment;


class FinancialStatementController extends Controller
{
    protected $path;
    public function __construct()
    {
        $this->path = 'inventory.financial_statement';
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view($this->path.'.index');
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

    public function show_report(Request $request)
    {
        // return $request->all();
        $total_sales = sales_ledger::whereMonth('invoice_date',$request->month)->whereYear('invoice_date',$request->year)->sum('total');
        return view($this->path.'.show_report');
    }
}
