<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\Date;
use App\Models\sales_ledger;

class SalesProfitController extends Controller
{
    protected $path;
    public function __construct()
    {
        $this->path = 'inventory.sales_profit';
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

    public function show_sales_report(Request $request)
    {
        if($request->report_type == 'Daily')
        {
            $date = Date::DateToDb('/',$request->date);
            $data = sales_ledger::where('invoice_date',$date)->get();
        }
        elseif($request->report_type == 'Monthly')
        {
            $data = sales_ledger::whereMonth('invoice_date',$request->month)->whereYear('invoice_date',$request->year)->get();
        }
        elseif($request->report_type == 'Yearly')
        {
            $data = sales_ledger::whereYear('invoice_date',$request->year)->get();
        }

        $data = array(
            'report_type' => $request->report_type,
            'data' => $data,
            'search_date' => '',
        );

        if($request->report_type == 'Daily')
        {
            $data['search_date'] = $request->date;
        }
        elseif($request->report_type == 'Monthly')
        {
            $monthName = Date::getMonthName($request->month);
            $data['search_date'] = 'Month : '.$monthName.' || Year : '.$request->year;
        }
        elseif($request->report_type == 'Yearly')
        {
            $data['search_date'] = $request->year;
        }

        return view($this->path.'.show_report',compact('data'));
    }
}
