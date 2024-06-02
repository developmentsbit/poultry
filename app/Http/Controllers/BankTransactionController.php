<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\bank_info;
use App\Models\bank_transaction;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use DataTables;
use Auth;

class BankTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = bank_transaction::leftjoin('bank_infos','bank_infos.id','bank_transactions.account_id')
                    ->select('bank_transactions.*','bank_infos.bank_name','bank_infos.account_number','bank_infos.account_type')
                    ->get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('bank_infos',function($row){
                return '<span>'.$row->bank_name.'('.$row->account_type.')</span><br>
                <b>'.$row->account_number.'</b>';
            })
            ->addColumn('transaction_type',function($row){
                if($row->transaction_type == '1')
                {
                    return 'Deposit';
                }
                elseif($row->transaction_type == '2')
                {
                    return 'Withdraw';
                }
                elseif($row->transaction_type == '3')
                {
                    return 'Bank Account Cost';
                }
                else
                {
                    return 'Bank Account Interest';
                }
            })
            ->addColumn('action', function($row){
                $btn = '<div class="dropdown">
                    <a class="btn btn-secondary dropdown-toggle btn-sm" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a onclick="return Confirm()" class="dropdown-item" href="'.route('bank_transaction.edit',$row->id).'"><i class="fa fa-edit"></i> Edit</a>
                        <form action="'.route('bank_transaction.destroy',$row->id).'" method="post">
                        '.csrf_field().'
                        '.method_field("DELETE").'
                        <button onclick="return Confirm()" type="submit" class="dropdown-item text-danger"><i class="fa fa-trash"></i> Delete</button>
                        </form>
                    </div>
                </div>';
                return $btn;
            })
            ->rawColumns(['action','bank_infos','transaction_type'])
            ->make(true);


        }
        return view('inventory.bank_transaction.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bank = bank_info::get();
        return view('inventory.bank_transaction.create',compact('bank'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $data = array(
            "account_id" =>$request->account_id,
            "date" =>$request->date,
            "transaction_type"=>$request->transaction_type,
            "amount" => $request->amount,
            "voucher_cheque_no" => $request->voucher_cheque_no,
            "entry_date"=>date('Y-m-d'),
            'admin_id'=>Auth::user()->id,
            'branch_id'=>Auth::user()->branch,
        );

        bank_transaction::insert($data);
        Toastr::success('Bank Transaction Created', 'Success');
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
        $bank = bank_info::get();
        $data = bank_transaction::find($id);

        $deposit = bank_transaction::where('transaction_type','1')->where('account_id',$data->account_id)->sum('amount');

        $withdraw = bank_transaction::where('transaction_type','2')->where('account_id',$data->account_id)->sum('amount');

        $bank_cost = bank_transaction::where('transaction_type','3')->where('account_id',$data->account_id)->sum('amount');

        $interest = bank_transaction::where('transaction_type','4')->where('account_id',$data->account_id)->sum('amount');

        $result = ($deposit + $interest) - ($withdraw + $bank_cost);
        return view('inventory.bank_transaction.edit',compact('bank','data','result'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = array(
            "account_id" =>$request->account_id,
            "date" =>$request->date,
            "transaction_type"=>$request->transaction_type,
            "amount" => $request->amount,
            "voucher_cheque_no" => $request->voucher_cheque_no,
            "entry_date"=>date('Y-m-d'),
            'admin_id'=>Auth::user()->id,
            'branch_id'=>Auth::user()->branch,
        );

        bank_transaction::find($id)->update($data);
        Toastr::success('Bank Transaction Updated', 'Success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        bank_transaction::find($id)->delete();
        Toastr::success('Bank Transaction Deleted', 'Success');
        return redirect()->back();
    }

    public function gettotalamount(Request $request)
    {
        $deposit = bank_transaction::where('transaction_type','1')->where('account_id',$request->account_id)->sum('amount');

        $withdraw = bank_transaction::where('transaction_type','2')->where('account_id',$request->account_id)->sum('amount');

        $bank_cost = bank_transaction::where('transaction_type','3')->where('account_id',$request->account_id)->sum('amount');

        $interest = bank_transaction::where('transaction_type','4')->where('account_id',$request->account_id)->sum('amount');

        $result = ($deposit + $interest) - ($withdraw + $bank_cost);

        return $result;
    }

    public function retrive_bank_transaction($id)
    {
        bank_transaction::where('id',$id)->withTrashed()->restore();
        Toastr::success('Bank Transaction Restored', 'Success');
        return redirect()->back();
    }

    public function bank_trans_perdelete($id)
    {
        bank_transaction::where('id',$id)->withTrashed()->forceDelete();
        Toastr::success('Bank Transaction Deleted', 'Success');
        return redirect()->back();
    }
}
