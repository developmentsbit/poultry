<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\cash_close;
use App\Models\sales_ledger;
use App\Models\supplier_payment;
use App\Models\bank_transaction;
use App\Models\income_entry;
use App\Models\loan_recived;
use App\Models\internal_loan_recived;
use App\Models\purchase_ledger;
use App\Models\sales_payment;
use App\Models\expense_entry;
use App\Models\loan_provide;
use App\Models\internal_loan_provide;
use App\Models\employee_salary_payment;

class CashCloseReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('inventory.cash_close_report.index');
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

    public function show_cash_close_report(Request $request)
    {
        // return [$last_close_date,$request->date];
        $last_cash_date = cash_close::orderby('cash_date','DESC')->skip(1)->take(1)->first();

        $last_close_date = $last_cash_date->cash_date;

        $check = cash_close::where('cash_date',$request->date)->first();

        if($check)
        {
            $sales = sales_ledger::whereBetween('invoice_date',[$last_close_date,$request->date])->get();
            $total_sales = sales_ledger::whereBetween('invoice_date',[$last_close_date,$request->date])->sum('paid_amount');


            $purchase_return = supplier_payment::whereBetween('entry_date',[$last_close_date,$request->date])
                                ->sum('returnpaid');
            if($purchase_return < 0)
            {

                $explode = explode('-',$purchase_return);

                $purchase_returns = $explode[1];
            }
            else
            {
                $purchase_returns = supplier_payment::whereBetween('entry_date',[$last_close_date,$request->date])
                ->sum('return_amount');
            }


            $bank_withdraw = bank_transaction::leftjoin('bank_infos','bank_infos.id','bank_transactions.account_id')
            ->whereBetween('bank_transactions.entry_date',[$last_close_date,$request->date])
            ->where('bank_transactions.transaction_type',2)
            ->get();
            $total_bank_withdraw =bank_transaction::whereBetween('bank_transactions.entry_date',[$last_close_date,$request->date])
            ->where('bank_transactions.transaction_type',2)
            ->sum('amount');


            $bank_interset = bank_transaction::leftjoin('bank_infos','bank_infos.id','bank_transactions.account_id')
            ->whereBetween('bank_transactions.entry_date',[$last_close_date,$request->date])
            ->where('bank_transactions.transaction_type',4)
            ->get();
            $total_bank_interest =bank_transaction::whereBetween('bank_transactions.entry_date',[$last_close_date,$request->date])
            ->where('bank_transactions.transaction_type',4)
            ->sum('amount');

            $income_entry = income_entry::leftjoin('income_expense_titles','income_expense_titles.id','income_entries.income_id')->whereBetween('income_entries.date',[$last_close_date,$request->date])
            ->select('income_entries.*','income_expense_titles.title_en')
            ->get();
            $total_income = income_entry::whereBetween('income_entries.date',[$last_close_date,$request->date])->sum('amount');


            $loan_recived = loan_recived::leftjoin('loan_registers','loan_registers.id','loan_reciveds.register_id')
            ->whereBetween('loan_reciveds.date',[$last_close_date,$request->date])
            ->get();
            $total_loan_recived = loan_recived::whereBetween('loan_reciveds.date',[$last_close_date,$request->date])->sum('amount');


            $internal_loan_reciveds = internal_loan_recived::leftjoin('internal_loan_registers','internal_loan_registers.id','internal_loan_reciveds.register_id')
            ->whereBetween('internal_loan_reciveds.date',[$last_close_date,$request->date])
            ->get();
            $total_internal_loan_reciveds = internal_loan_recived::whereBetween('internal_loan_reciveds.date',[$last_close_date,$request->date])
            ->sum('amount');

            $customer_payment = sales_payment::whereBetween('entry_date',[$last_cash_date,$request->date])->get();
            $total_customer_payment = sales_payment::whereBetween('entry_date',[$last_cash_date,$request->date])->sum('payment_amount');


            // =======expense=========

            $purchase = purchase_ledger::whereBetween('invoice_date',[$last_close_date,$request->date])->get();
            $total_purchase = purchase_ledger::whereBetween('invoice_date',[$last_close_date,$request->date])->sum('paid');

            $sales_return = sales_payment::whereBetween('entry_date',[$last_close_date,$request->date])
                                        ->sum('returnpaid');
            if($sales_return < 0)
            {

                $explode1 = explode('-',$sales_return);

                $sales_returns = $explode1[1];
            }
            else
            {
                $sales_returns= sales_payment::whereBetween('entry_date',[$last_close_date,$request->date])
                ->sum('return_amount');
            }


            $supplier_payment = supplier_payment::whereBetween('payment_date',[$last_close_date,$request->date])->get();
            $total_supplier_payment = supplier_payment::whereBetween('payment_date',[$last_close_date,$request->date])->sum('payment');


            $others_expense = expense_entry::leftjoin('income_expense_titles','income_expense_titles.id','expense_entries.expense_id')
            ->whereBetween('expense_entries.date',[$last_close_date,$request->date])
            ->get();
            $total_expense = expense_entry::whereBetween('date',[$last_close_date,$request->date])->sum('amount');

            $bank_deposit = bank_transaction::leftjoin('bank_infos','bank_infos.id','bank_transactions.account_id')
            ->where('bank_transactions.transaction_type',1)
            ->whereBetween('bank_transactions.entry_date',[$last_close_date,$request->date])
            ->select('bank_infos.bank_name','bank_transactions.*')
            ->get();
            $total_deposit = bank_transaction::where('transaction_type',1)->whereBetween('entry_date',[$last_close_date,$request->date])->sum('amount');



            $bank_cost = $bank_deposit = bank_transaction::leftjoin('bank_infos','bank_infos.id','bank_transactions.account_id')
            ->where('bank_transactions.transaction_type',3)
            ->whereBetween('bank_transactions.entry_date',[$last_close_date,$request->date])
            ->select('bank_infos.bank_name','bank_transactions.*')
            ->get();
            $total_bank_cost = bank_transaction::where('transaction_type',3)->whereBetween('entry_date',[$last_close_date,$request->date])->sum('amount');


            $loan_provide = loan_provide::leftjoin('loan_registers','loan_registers.id','loan_provides.register_id')
            ->whereBetween('loan_provides.date',[$last_close_date,$request->date])
            ->get();
            $total_loan_provide = loan_provide::whereBetween('loan_provides.date',[$last_close_date,$request->date])
            ->sum('amount');

            $internal_loan_provide = internal_loan_provide::leftjoin('internal_loan_registers','internal_loan_registers.id','internal_loan_provides.register_id')
            ->whereBetween('internal_loan_provides.date',[$last_close_date,$request->date])
            ->get();
            $total_internal_loan_provide = internal_loan_provide::where('internal_loan_provides.date',[$last_close_date,$request->date])
            ->sum('amount');

            $salary_payment = employee_salary_payment::leftjoin('employee_infos','employee_infos.id','employee_salary_payments.employee_id')
            ->whereBetween('employee_salary_payments.date',[$last_close_date,$request->date])
            ->where('employee_salary_payments.salary_withdraw','>','0')
            ->get();
            $total_salary_payment = employee_salary_payment::whereBetween('employee_salary_payments.date',[$last_close_date,$request->date])
            ->where('employee_salary_payments.salary_withdraw','>','0')
            ->sum('salary_withdraw');



            $total_incomes = $total_sales + $purchase_returns + $total_bank_withdraw + $total_bank_interest +  $total_income + $total_loan_recived + $total_internal_loan_reciveds;

            $total_expenses = $total_purchase + $sales_returns + $total_expense + $total_deposit + $total_bank_cost + $total_loan_provide + $total_internal_loan_provide + $total_salary_payment;





            return view('inventory.cash_close_report.show_cash_close_report',compact('sales','total_sales','purchase_returns','bank_withdraw','total_bank_withdraw','bank_interset','total_bank_interest','income_entry','total_income','loan_recived','total_loan_recived','internal_loan_reciveds','total_internal_loan_reciveds','purchase','total_purchase','sales_returns','others_expense','total_expense','bank_deposit','total_deposit','bank_cost','total_bank_cost','loan_provide','total_loan_provide','internal_loan_provide','total_internal_loan_provide','salary_payment','total_salary_payment','total_incomes','total_expenses','customer_payment','total_customer_payment','supplier_payment','total_supplier_payment'));
        }
        else
        {
            return redirect()->back();
        }
    }
}
