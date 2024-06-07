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
use DateTime;

class CashCloseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return date('Y-m-d');
        $check = cash_close::where('cash_date',date('Y-m-d'))->count();
        if($check > 0)
        {
            $today_cash = true;
        }
        else
        {
            $today_cash = false;
        }

        $previous_cash = cash_close::orderBy('cash_date','DESC')->first();
        $today_date = date('Y-m-d');
        // return $previous_cash;
        if(isset($previous_cash))
        {
            $cash_date = $previous_cash->cash_date;
            $last_cash_date = date('Y-m-d', strtotime($cash_date. ' + 1 days'));

            // return $last_cash_date;
            $previous_cash = $previous_cash->cash;
        }
        else
        {
            $last_cash_date = '2000-01-01';
            $previous_cash = 0;
        }

        $customer_payment = sales_payment::whereBetween('entry_date',[$last_cash_date,$today_date])
        ->where('payment_amount','>',0)->sum('payment_amount');

        $purchase_return = supplier_payment::whereBetween('payment_date',[$last_cash_date,$today_date])->sum('return_amount');

        $bank_withdraw = bank_transaction::where('transaction_type',2)->whereBetween('date',[$last_cash_date,$today_date])->sum('amount');

        $bank_interest = bank_transaction::where('transaction_type',4)->whereBetween('date',[$last_cash_date,$today_date])->sum('amount');

        $income = income_entry::whereBetween('date',[$last_cash_date,$today_date])->sum('amount');


        $loan_recived = loan_recived::whereBetween('date',[$last_cash_date,$today_date])->sum('amount');

        $internal_loan_recived = internal_loan_recived::whereBetween('date',[$last_cash_date,$today_date])->sum('amount');

        $supplier_loan = supplier_payment::whereBetween('payment_date',[$last_cash_date,$today_date])->where('payment','<',0)->sum('payment');

        $supplier_loans = $supplier_loan * -1;

        $total_income = $previous_cash + $customer_payment + $purchase_return + $bank_withdraw + $bank_interest + $income + $loan_recived + $internal_loan_recived + $supplier_loans;


        /// expense

        $supplier_payment = supplier_payment::whereBetween('payment_date',[$last_cash_date,$today_date])->where('payment','>',0)->sum('payment');

        $customer_loan = sales_payment::whereBetween('entry_date',[$last_cash_date,$today_date])->where('payment_amount','<',0)->sum('payment_amount');

        $expense = expense_entry::whereBetween('entry_date',[$last_cash_date,$today_date])->sum('amount');

        $sales_return = sales_payment::whereBetween('entry_date',[$last_cash_date,$today_date])->sum('return_amount');

        $bank_deposit = bank_transaction::whereBetween('date',[$last_cash_date,$today_date])->where('transaction_type',1)->sum('amount');

        $bank_acc_cost = bank_transaction::whereBetween('date',[$last_cash_date,$today_date])->where('transaction_type',3)->sum('amount');

        $loan_provide = loan_provide::whereBetween('date',[$last_cash_date,$today_date])->sum('amount');

        $internal_loan_provide = internal_loan_provide::whereBetween('date',[$last_cash_date,$today_date])->sum('amount');

        $salary = employee_salary_payment::whereBetween('date',[$last_cash_date,$today_date])->sum('salary_withdraw');
        $customer_loans = $customer_loan * -1;

        $total_expense = $supplier_payment + $expense + $sales_return + $bank_deposit + $bank_acc_cost + $loan_provide + $internal_loan_provide + $salary + $customer_loans;


        $bankbalance =  ($bank_deposit + $bank_acc_cost) - ($bank_withdraw + $bank_interest) ;

        $cash = $total_income - $total_expense;
        $cash_in_hand = $cash - $bankbalance;


        return view('inventory.cash.index',compact('previous_cash','customer_payment','purchase_return','bank_withdraw','bank_interest','income','loan_recived','expense','supplier_payment','internal_loan_recived','total_income','sales_return','bank_deposit','bank_acc_cost','loan_provide','internal_loan_provide','salary','total_expense','bankbalance','cash','cash_in_hand','today_cash','last_cash_date','today_date','customer_loans','supplier_loans'));
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
            'customer_loan' => $request->customer_loan,
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

    public function customer_payment_details($from_date, $today_date)
    {
        $data = sales_payment::leftjoin('customer_infos','customer_infos.customer_id','sales_payments.customer_id')
        ->whereBetween('sales_payments.entry_date',[$from_date,$today_date])
        ->where('sales_payments.payment_amount','>',0)
        ->select('sales_payments.*','customer_infos.customer_name_en')
        ->get();

        $total = sales_payment::whereBetween('sales_payments.entry_date',[$from_date,$today_date])
        ->where('sales_payments.payment_amount','>',0)
        ->sum('payment_amount');
        return view('inventory.cash.customer_payment_details',compact('from_date','today_date','data','total'));
    }

    public function purchase_return_details($from_date,$today_date)
    {
        $data = supplier_payment::where('return_amount','>',0)->whereBetween('payment_date',[$from_date,$today_date])->get();
        return view('inventory.cash.purchase_return_details',compact('from_date','today_date','data'));
    }

    public function bank_withdraw_details($from_date,$today_date)
    {
        $data = bank_transaction::leftjoin('bank_infos','bank_infos.id','bank_transactions.account_id')
        ->whereBetween('bank_transactions.date',[$from_date,$today_date])
        ->where('transaction_type',2)
        ->get();
        $total = bank_transaction::whereBetween('bank_transactions.date',[$from_date,$today_date])
        ->where('transaction_type',2)
        ->sum('amount');
        return view('inventory.cash.bank_withdraw_details',compact('from_date','today_date','data','total'));
    }

    public function bank_interest_details($from_date,$today_date)
    {
        $data = bank_transaction::leftjoin('bank_infos','bank_infos.id','bank_transactions.account_id')
        ->where('bank_transactions.transaction_type',4)
        ->whereBetween('bank_transactions.date',[$from_date,$today_date])
        ->get();

        $total = bank_transaction::where('bank_transactions.transaction_type',4)
        ->whereBetween('bank_transactions.date',[$from_date,$today_date])
        ->sum('amount');

        return view('inventory.cash.bank_interest_details',compact('data','from_date','today_date','total'));
    }

    public function others_income_details($from_date, $today_date)
    {
        $data = income_entry::leftjoin('income_expense_titles','income_expense_titles.id','income_entries.income_id')
        ->whereBetween('income_entries.date',[$from_date,$today_date])
        ->get();

        $total = income_entry::whereBetween('income_entries.date',[$from_date,$today_date])
        ->sum('amount');

        return view('inventory.cash.others_income_details',compact('data','from_date','today_date','total'));
    }

    public function loan_recived_details($from_date, $today_date)
    {
        $data = loan_recived::leftjoin('loan_registers','loan_registers.id','loan_reciveds.register_id')
        ->whereBetween('loan_reciveds.date',[$from_date,$today_date])
        ->get();

        $total = loan_recived::whereBetween('loan_reciveds.date',[$from_date,$today_date])
        ->sum('amount');

        return view('inventory.cash.loan_recived_details',compact('data','from_date','today_date','total'));
    }

    public function internal_loan_recived_details($from_date, $today_date)
    {
        $data = internal_loan_recived::leftjoin('internal_loan_registers','internal_loan_registers.id','internal_loan_reciveds.register_id')
        ->whereBetween('internal_loan_reciveds.date',[$from_date,$today_date])
        ->get();

        $total = internal_loan_recived::whereBetween('internal_loan_reciveds.date',[$from_date,$today_date])
        ->sum('amount');

        return view('inventory.cash.internal_loan_recived_details',compact('data','from_date','today_date','total'));
    }

    public function supplier_loans_details($from_date, $today_date)
    {
        $data = supplier_payment::leftjoin('supplier_infos','supplier_infos.supplier_id','supplier_payments.supplier_id')
        ->where('payment','<',0)
        ->whereBetween('supplier_payments.payment_date',[$from_date,$today_date])
        ->get();

        $total = supplier_payment::whereBetween('supplier_payments.payment_date',[$from_date,$today_date])
        ->where('payment','<',0)->sum('payment');

        return view('inventory.cash.supplier_loans_details',compact('data','from_date','today_date','total'));
    }

    public function supplier_payment_details($from_date, $today_date)
    {
        $data = supplier_payment::leftjoin('supplier_infos','supplier_infos.supplier_id','supplier_payments.supplier_id')
        ->where('payment','>',0)
        ->whereBetween('supplier_payments.payment_date',[$from_date,$today_date])
        ->get();

        $total = supplier_payment::whereBetween('supplier_payments.payment_date',[$from_date,$today_date])
        ->where('payment','>',0)->sum('payment');

        return view('inventory.cash.supplier_payment_details',compact('data','from_date','today_date','total'));
    }

    public function sales_return_details($from_date, $today_date)
    {
        $data = sales_payment::leftjoin('customer_infos','customer_infos.customer_id','sales_payments.customer_id')
        ->where('return_amount','>',0)
        ->whereBetween('sales_payments.entry_date',[$from_date,$today_date])
        ->get();

        $total = sales_payment::whereBetween('sales_payments.entry_date',[$from_date,$today_date])
        ->where('return_amount','>',0)->sum('return_amount');

        return view('inventory.cash.sales_return_details',compact('data','from_date','today_date','total'));
    }

    public function others_expense_details($from_date, $today_date)
    {
        $data = expense_entry::leftjoin('income_expense_titles','income_expense_titles.id','expense_entries.expense_id')
        ->whereBetween('expense_entries.date',[$from_date,$today_date])
        ->get();

        $total = expense_entry::whereBetween('expense_entries.date',[$from_date,$today_date])
        ->sum('amount');

        return view('inventory.cash.others_expense_details',compact('data','from_date','today_date','total'));
    }

    public function bank_deposit_details($from_date,$today_date)
    {
        $data = bank_transaction::leftjoin('bank_infos','bank_infos.id','bank_transactions.account_id')
        ->where('bank_transactions.transaction_type',1)
        ->whereBetween('bank_transactions.date',[$from_date,$today_date])
        ->get();

        $total = bank_transaction::where('bank_transactions.transaction_type',1)
        ->whereBetween('bank_transactions.date',[$from_date,$today_date])
        ->sum('amount');

        return view('inventory.cash.bank_deposit_details',compact('data','from_date','today_date','total'));
    }

    public function bank_acc_cost_details($from_date,$today_date)
    {
        $data = bank_transaction::leftjoin('bank_infos','bank_infos.id','bank_transactions.account_id')
        ->where('bank_transactions.transaction_type',3)
        ->whereBetween('bank_transactions.date',[$from_date,$today_date])
        ->get();

        $total = bank_transaction::where('bank_transactions.transaction_type',3)
        ->whereBetween('bank_transactions.date',[$from_date,$today_date])
        ->sum('amount');

        return view('inventory.cash.bank_acc_cost_details',compact('data','from_date','today_date','total'));
    }

    public function loan_provide_details($from_date, $today_date)
    {
        $data = loan_provide::leftjoin('loan_registers','loan_registers.id','loan_provides.register_id')
        ->whereBetween('loan_provides.date',[$from_date,$today_date])
        ->get();

        $total = loan_provide::whereBetween('loan_provides.date',[$from_date,$today_date])
        ->sum('amount');

        return view('inventory.cash.loan_provide_details',compact('data','from_date','today_date','total'));
    }

    public function internal_loan_provide_details($from_date, $today_date)
    {
        $data = internal_loan_provide::leftjoin('loan_registers','loan_registers.id','internal_loan_provides.register_id')
        ->whereBetween('internal_loan_provides.date',[$from_date,$today_date])
        ->get();

        $total = internal_loan_provide::whereBetween('internal_loan_provides.date',[$from_date,$today_date])
        ->sum('amount');

        return view('inventory.cash.internal_loan_provide_details',compact('data','from_date','today_date','total'));
    }

    public function salary_details($from_date, $today_date)
    {
        $data = employee_salary_payment::leftjoin('employee_infos','employee_infos.id','employee_salary_payments.employee_id')
        ->where('salary_withdraw','>',0)
        ->whereBetween('employee_salary_payments.date',[$from_date,$today_date])
        ->get();

        $total = employee_salary_payment::whereBetween('employee_salary_payments.date',[$from_date,$today_date])
        ->where('salary_withdraw','>',0)
        ->sum('salary_withdraw');

        return view('inventory.cash.salary_details',compact('data','from_date','today_date','total'));
    }

    public function customer_loans_details($from_date, $today_date)
    {
        $data = sales_payment::leftjoin('customer_infos','customer_infos.customer_id','sales_payments.customer_id')
        ->where('payment_amount','<',0)
        ->whereBetween('sales_payments.entry_date',[$from_date,$today_date])
        ->get();

        $total = sales_payment::whereBetween('sales_payments.entry_date',[$from_date,$today_date])
        ->where('payment_amount','<',0)->sum('payment_amount');

        return view('inventory.cash.customer_loans_details',compact('data','from_date','today_date','total'));
    }

}
