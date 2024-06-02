<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\bank_info;
use App\Models\bank_transaction;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use DataTables;
use Auth;

class BankTransController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bank = bank_info::get();
        return view('inventory.bank_report.index',compact('bank'));
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
        dd($request->all());
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

    public function show_bank_report(Request $request)
    {
        // return $request->bank_id;
        $bank_info = bank_info::where('id',$request->bank_id)->first();
        $bank_transaction = bank_transaction::where('account_id',$request->bank_id)
        ->whereBetween('date',[$request->from_date,$request->to_date])
        ->get();
        $i = 1;

        $total_deposit = bank_transaction::where('account_id',$request->bank_id)->where('transaction_type',1)->whereBetween('date',[$request->from_date,$request->to_date])->sum('amount');
        $total_withdraw = bank_transaction::where('account_id',$request->bank_id)->where('transaction_type',2)->whereBetween('date',[$request->from_date,$request->to_date])->sum('amount');
        $total_accost = bank_transaction::where('account_id',$request->bank_id)->where('transaction_type',3)->whereBetween('date',[$request->from_date,$request->to_date])->sum('amount');
        $total_interest = bank_transaction::where('account_id',$request->bank_id)->where('transaction_type',4)->whereBetween('date',[$request->from_date,$request->to_date])->sum('amount');

        $balance = ($total_deposit + $total_interest) - ($total_withdraw + $total_accost);

        return view('inventory.bank_report.show_bank_report',compact('bank_info','bank_transaction','i','total_deposit','total_withdraw','total_accost','total_interest','balance'));
    }

    public function withdraw_cc_loan()
    {
        $data = [];
        $data['bank'] = bank_info::where('account_type','CC Loan')->get();
        return view('inventory.bank.withdraw_cc_loan',compact('data'));
    }

    public function getLimitBalance(Request $request)
    {
        $data = bank_info::where('id',$request->acc_number)->first();
        $total_deposit = bank_transaction::where('account_id',$request->acc_number)->where('transaction_type',1)->sum('amount');
        $total_withdraw = bank_transaction::where('account_id',$request->acc_number)->where('transaction_type',2)->sum('amount');

        $retained_balance = ($data->limit + $total_deposit) - $total_withdraw;

        $res = [
            $data->limit,$retained_balance
        ];

        return response()->json($res,200);
    }

    public function withDrawCCloan(Request $request)
    {
        // dd($request->all());
        bank_transaction::create([
            'account_id' => $request->account_id,
            'date' => $request->date,
            'amount' => $request->amount,
            'voucher_cheque_no' => $request->voucher_cheque_no,
            'transaction_type' => 2,
            'admin_id' => Auth::user()->id,
            'branch_id' => Auth::user()->branch,
        ]);

        Toastr::success('CC Loan Withdraw Successfully', 'Success');
        return redirect()->back();
    }

    public function deposit_cc_loan()
    {
        $data = [];
        $data['bank'] = bank_info::where('account_type','CC Loan')->get();
        return view('inventory.bank.deposit_cc_loan',compact('data'));
    }

    public function depositCCloan(Request $request)
    {
        // dd($request->all());
        bank_transaction::create([
            'account_id' => $request->account_id,
            'date' => $request->date,
            'amount' => $request->amount,
            'voucher_cheque_no' => $request->voucher_cheque_no,
            'transaction_type' => 1,
            'admin_id' => Auth::user()->id,
            'branch_id' => Auth::user()->branch,
        ]);

        Toastr::success('CC Loan Deposit Successfully', 'Success');
        return redirect()->back();
    }

}
