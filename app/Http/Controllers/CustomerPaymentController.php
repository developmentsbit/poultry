<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use Auth;
use App\Models\customer_info;
use App\Models\sales_payment;
use App\Models\sales_entry;
use App\Models\sales_ledger;

class CustomerPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = sales_payment::leftjoin('customer_infos','customer_infos.customer_id','sales_payments.customer_id')
            ->select('sales_payments.*','customer_infos.customer_name_en','customer_infos.customer_phone')
            ->get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('customer_details',function($row){
                return '<b>'.$row->customer_name_en.'</b><br>
                <span>'.$row->customer_phone.'</span><br>';
            })
            ->addColumn('action', function($row){
                $btn = '<div class="dropdown">
                    <a class="btn btn-secondary dropdown-toggle btn-sm" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" target="_blank" href="'.route('customer_payment.show',$row->id).'"><i class="fa fa-eye"></i> Show Invoice</a>
                        <form action="'.route('customer_payment.destroy',$row->id).'" method="post">
                        '.csrf_field().'
                        '.method_field("DELETE").'
                        <button onclick="return Confirm()" type="submit" class="dropdown-item text-danger"><i class="fa fa-trash"></i> Delete</button>
                        </form>
                    </div>
                </div>';
                return $btn;
            })
            ->rawColumns(['action','customer_details'])
            ->make(true);


        }
        return view('inventory.customer_payment.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customer = customer_info::get();
        return view('inventory.customer_payment.create',compact('customer'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $date = date('Y-m-d');
        $data = array(
            'entry_date'=>$date,
            'customer_id'=>$request->customer_id,
            'payment_amount'=>$request->payment,
            'discount' => $request->discount,
            'note'=>$request->comment,
            'admin_id'=>Auth::user()->id,
            'branch_id'=>Auth::user()->branch,
        );

        sales_payment::insert($data);

        Toastr::success('Customer Payment Successfully', 'Success');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = sales_payment::leftjoin('customer_infos','customer_infos.customer_id','sales_payments.customer_id')
        ->select('sales_payments.*','customer_infos.customer_name_en','customer_infos.customer_phone')
        ->where('sales_payments.id',$id)
        ->first();
        $total_sales = sales_ledger::where('customer_id',$data->customer_id)->sum('total');
        $total_discount = sales_ledger::where('customer_id',$data->customer_id)->sum('final_discount');
        $paid_amount = sales_ledger::where('customer_id',$data->customer_id)->sum('paid_amount');
        $previous_due = sales_payment::where('customer_id',$data->customer_id)->sum('previous_due');
        $return_amount = sales_payment::where('customer_id',$data->customer_id)->sum('return_amount');
        $sales_payment = sales_payment::where('customer_id',$data->customer_id)->sum('payment_amount');
        $return_paid = sales_payment::where('customer_id',$data->customer_id)->sum('returnpaid');


        $grandtotal = $total_sales - $total_discount;

        $total = ($grandtotal - $sales_payment)  + $previous_due;

        $subtotal = ($total - $return_amount) - $return_paid;

        // return $subtotal;
        return view('inventory.customer_payment.payment_invoice',compact('data','subtotal'));
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
        sales_payment::find($id)->delete();
        Toastr::success('Supplier Payment Delete Successfully', 'Success');
        return redirect()->back();
    }

    public function getcustomerInfo($id)
    {
        $data = customer_info::where('customer_id',$id)->first();
        return view('inventory.customer_payment.customer_info',compact('data'));
    }

    public function getCustomerDue($customer_id)
    {
        $total_sales = sales_ledger::where('customer_id',$customer_id)->sum('total');

        $total_discount = sales_ledger::where('customer_id',$customer_id)->sum('final_discount');

        $paid_amount = sales_ledger::where('customer_id',$customer_id)->sum('paid_amount');

        $previous_due = sales_payment::where('customer_id',$customer_id)->sum('previous_due');

        $return_amount = sales_payment::where('customer_id',$customer_id)->sum('return_amount');

        $sales_payment = sales_payment::where('customer_id',$customer_id)->sum('payment_amount');

        $return_paid = sales_payment::where('customer_id',$customer_id)->sum('returnpaid');

        $sales_payment_discount = sales_payment::where('customer_id',$customer_id)->sum('discount');


        $grandtotal = $total_sales - $total_discount;

        $total = (($grandtotal - $sales_payment) - $sales_payment_discount)  + $previous_due;

        $subtotal = ($total - $return_amount) - $return_paid;

        return $subtotal;
    }

    public function retrive_customer_payment($id)
    {
        sales_payment::where('id',$id)->withTrashed()->restore();
        Toastr::success('Customer Payment Retrive Successfully', 'Success');
        return redirect()->back();
    }

    public function customer_payment_perdelete($id)
    {
        sales_payment::where('id',$id)->withTrashed()->forceDelete();
        Toastr::success('Customer Payment Delete Successfully', 'Success');
        return redirect()->back();
    }

    public function customer_advance_pay()
    {
        $customer = customer_info::get();

        return view('inventory.customer_payment.customer_advance_pay',compact('customer'));
    }

    public function customer_loan()
    {
        $customer = customer_info::get();

        return view('inventory.customer_payment.customer_loan',compact('customer'));
    }

    public function customer_loan_store(Request $request)
    {
        // return $request->payment * -1;
        $date = date('Y-m-d');
        $data = array(
            'entry_date'=>$date,
            'customer_id'=>$request->customer_id,
            'payment_amount'=>$request->payment * -1,
            'note'=>$request->comment,
            'admin_id'=>Auth::user()->id,
            'branch_id'=>Auth::user()->branch,
        );

        sales_payment::insert($data);

        Toastr::success('Customer Loan Store Successfully', 'Success');
        return redirect()->back();
    }

}
