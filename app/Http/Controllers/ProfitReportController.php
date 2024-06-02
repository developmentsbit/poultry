<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product_item;
use App\Models\sales_entry;
use App\Models\sales_ledger;
use App\Models\income_entry;
use App\Models\expense_entry;
use App\Models\employee_salary_payment;
use App\Traits\Date;
use DB;

class ProfitReportController extends Controller
{
    protected $path;
    public function __construct()
    {
        $this->path = 'inventory.profit_report';
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

    public function show_profit_report(Request $request)
    {
        $data = array(
            'search_date' => '',
            'month' =>'',
            'year' => '',
            'report_type' => $request->report_type,
        );
        if($request->report_type == 'Daily')
        {
            $profitData = sales_entry::leftjoin('sales_ledgers','sales_entries.invoice_no','sales_ledgers.invoice_no')
            ->leftjoin('product_informations','product_informations.pdt_id','sales_entries.product_id')
            ->leftjoin('product_items','product_items.item_id','product_informations.pdt_item_id')
            ->where('sales_ledgers.invoice_date',$request->date)
            ->select(
                DB::raw("sum((sales_entries.product_sales_price - sales_entries.product_purchase_price) * sales_entries.product_quantity) as profit"
                )
                ,"product_items.item_name_en"
            )
            ->groupBy('product_informations.pdt_item_id')
            ->get();


            $sales_discount = sales_ledger::where('invoice_date',$request->date)->sum('final_discount');

            $total_incomes = income_entry::where('entry_date',$request->date)->sum('amount');

            $total_expense = expense_entry::where('entry_date',$request->date)->sum('amount');

            $salary_pay = employee_salary_payment::where('date',$request->date)->sum('salary_withdraw');
        }
        elseif($request->report_type == 'Monthly')
        {

            $profitData = sales_entry::leftjoin('sales_ledgers','sales_entries.invoice_no','sales_ledgers.invoice_no')
            ->leftjoin('product_informations','product_informations.pdt_id','sales_entries.product_id')
            ->leftjoin('product_items','product_items.item_id','product_informations.pdt_item_id')
            ->whereMonth('sales_ledgers.invoice_date',$request->month)
            ->whereYear('sales_ledgers.invoice_date',$request->year)
            ->select(
                DB::raw("sum((sales_entries.product_sales_price - sales_entries.product_purchase_price) * sales_entries.product_quantity) as profit"
                )
                ,"product_items.item_name_en"
            )
            ->groupBy('product_informations.pdt_item_id')
            ->get();


            $sales_discount = sales_ledger::whereMonth('invoice_date',$request->month)
            ->whereYear('invoice_date',$request->year)->sum('final_discount');

            $total_incomes = income_entry::whereMonth('entry_date',$request->month)
            ->whereYear('entry_date',$request->year)->sum('amount');

            $total_expense = expense_entry::whereMonth('entry_date',$request->month)
            ->whereYear('entry_date',$request->year)->sum('amount');

            $salary_pay = employee_salary_payment::whereMonth('date',$request->month)
            ->whereYear('date',$request->year)->sum('salary_withdraw');

            $monthName = Date::getMonthName($request->month);
            $data['search_date'] = 'Month : '.$monthName.' || Year : '.$request->year;
            $data['month'] = $request->month;
            $data['year'] = $request->year;
        }
        elseif($request->report_type == 'Yearly')
        {
            $profitData = sales_entry::leftjoin('sales_ledgers','sales_entries.invoice_no','sales_ledgers.invoice_no')
            ->leftjoin('product_informations','product_informations.pdt_id','sales_entries.product_id')
            ->leftjoin('product_items','product_items.item_id','product_informations.pdt_item_id')
            ->whereYear('sales_ledgers.invoice_date',$request->year)
            ->select(
                DB::raw("sum((sales_entries.product_sales_price - sales_entries.product_purchase_price) * sales_entries.product_quantity) as profit"
                )
                ,"product_items.item_name_en"
            )
            ->groupBy('product_informations.pdt_item_id')
            ->get();


            $sales_discount = sales_ledger::whereYear('invoice_date',$request->year)->sum('final_discount');

            $total_incomes = income_entry::whereYear('entry_date',$request->year)->sum('amount');

            $total_expense = expense_entry::whereYear('entry_date',$request->year)->sum('amount');

            $salary_pay = employee_salary_payment::whereYear('date',$request->year)->sum('salary_withdraw');

            $data['search_date'] = $request->year;
            $data['year'] = $request->year;
        }

        $data['profit_data'] = $profitData;
        $data['sales_discount'] = $sales_discount;
        $data['total_incomes'] = $total_incomes;
        $data['total_expense'] = $total_expense;
        $data['salary_pay'] = $salary_pay;
        return view($this->path.'.show_report',compact('data'));

    }
}
