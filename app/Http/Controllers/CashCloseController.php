<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\cash_close;
use App\Models\sales_payment;
use App\Models\purchase_entry;
use App\Models\supplier_payment;
use App\Models\income_entry;
use App\Models\loan_recived;
use App\Models\internal_loan_recived;
use App\Models\sales_entry;
use App\Models\expense_entry;
use App\Models\loan_provide;
use App\Models\internal_loan_provide;
use App\Models\bank_transaction;
use App\Models\cash_income;
use App\Models\cash_expense;
use App\Models\employee_salary_payment;
use Brian2694\Toastr\Facades\Toastr;
use Auth;

class CashCloseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $previous_cash = cash_close::orderBy('cash_date','DESC')->first();
        $today_date = date('Y-m-d');
        // return $previous_cash;
        if(isset($previous_cash))
        {
            $last_cash_date = $previous_cash->cash_date;
            $previous_cash = $previous_cash->cash;
        }
        else
        {
            $last_cash_date = '2000-01-01';
            $previous_cash = 0;
        }

        $customer_payment = sales_payment::whereBetween('entry_date',[$last_cash_date,$today_date])->sum('payment_amount');

        $purchase_return = supplier_payment::whereBetween('payment_date',[$last_cash_date,$today_date])->sum('return_amount');

        $bank_withdraw = bank_transaction::where('transaction_type',2)->whereBetween('date',[$last_cash_date,$today_date])->sum('amount');

        $bank_interest = bank_transaction::where('transaction_type',4)->whereBetween('date',[$last_cash_date,$today_date])->sum('amount');

        $income = income_entry::whereBetween('date',[$last_cash_date,$today_date])->sum('amount');


        $loan_recived = loan_recived::whereBetween('date',[$last_cash_date,$today_date])->sum('amount');


        /// expense

        $supplier_payment = supplier_payment::whereBetween('payment_date',[$last_cash_date,$today_date])->where('payment','>',0)->sum('payment');

        $expense = expense_entry::whereBetween('entry_date',[$last_cash_date,$today_date])->sum('amount');

        return view('inventory.cash.index',compact('previous_cash','customer_payment','purchase_return','bank_withdraw','bank_interest','income','loan_recived','expense','supplier_payment'));
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

        cash_close::insert([
            'cash_date'=>date('Y-m-d'),
            'cash'=>$request->cash,
            'bankbalance'=>$request->bankbalance,
            'comment'=>$request->comment,
            'admin_id'=>Auth::user()->id,
        ]);

        cash_income::insert([
            'cash_date'=>date('Y-m-d'),
            'sales'=>$request->sales,
            'others'=>$request->others,
            'bank_withdraw'=>$request->bank_withdraw,
            'bank_interest'=>$request->bank_interest,
            'purchase_return'=>$request->purchase_return,
            'loan_recived'=>$request->loan_recived,
            'intloan_recived'=>$request->intloan_recived,
            'admin_id'=>Auth::user()->id,
        ]);

        cash_expense::insert([
            'cash_date'=>date('Y-m-d'),
            'purchase'=>$request->purchase,
            'sales_return'=>$request->sales_return,
            'others_expense'=>$request->others_expense,
            'bank_deposit'=>$request->bank_deposit,
            'bank_cost'=>$request->bank_cost,
            'loan_provide'=>$request->loan_provide,
            'intloan_provide'=>$request->intloan_provide,
        ]);


        Toastr::success('Cash Close Submitted', 'Success');
        return redirect()->back();
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
}
