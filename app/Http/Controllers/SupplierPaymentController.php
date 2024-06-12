<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use Auth;
use App\Models\supplier_info;
use App\Models\purchase_ledger;
use App\Models\supplier_payment;

class SupplierPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = supplier_payment::leftjoin('supplier_infos','supplier_infos.supplier_id','supplier_payments.supplier_id')
            ->where('supplier_payments.branch_id',Auth::user()->branch)
            ->select('supplier_payments.*','supplier_infos.supplier_name_en','supplier_infos.supplier_phone')
            ->get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('supplier_details',function($row){
                return '<b>'.$row->supplier_name_en.'</b><br>
                <span>'.$row->supplier_phone.'</span><br>';
            })
            ->addColumn('action', function($row){
                $btn = '<div class="dropdown">
                    <a class="btn btn-secondary dropdown-toggle btn-sm" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                    </a>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a target="_blank" class="dropdown-item" href="'.route('supplier_payment.show',$row->id).'"><i class="fa fa-eye"></i> Show Payment Invoice</a>
                        <form action="'.route('supplier_payment.destroy',$row->id).'" method="post">
                        '.csrf_field().'
                        '.method_field("DELETE").'
                        <button onclick="return Confirm()" type="submit" class="dropdown-item text-danger"><i class="fa fa-trash"></i> Delete</button>
                        </form>
                    </div>
                </div>';
                return $btn;
            })
            ->rawColumns(['action','supplier_details'])
            ->make(true);


        }
        return view('inventory.supplier_payment.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $supplier = supplier_info::get();
        return view('inventory.supplier_payment.create',compact('supplier'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $payment_date = date('Y-m-d');

        // return $request->payment;

        $data = array(
            'payment_date'=>$payment_date,
            'supplier_id'=>$request->supplier_id,
            'payment'=>$request->payment,
            'discount' => $request->discount,
            'entry_date'=>$payment_date,
            'branch_id'=>Auth::user()->branch,
            'admin_id'=>Auth::user()->id,
        );

        supplier_payment::insert($data);

        Toastr::success('Supplier Payment Successfully', 'Success');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = supplier_payment::leftjoin('supplier_infos','supplier_infos.supplier_id','supplier_infos.supplier_id')
        ->select('supplier_infos.supplier_name_en','supplier_infos.supplier_phone','supplier_payments.*')
        ->where('supplier_payments.id',$id)
        ->first();

        $total_purchase = purchase_ledger::where('suplier_id',$data->supplier_id)->sum('total');

        $total_discount = purchase_ledger::where('suplier_id',$data->supplier_id)->sum('discount');

        $paid = purchase_ledger::where('suplier_id',$data->supplier_id)->sum('paid');

        $pd = supplier_payment::where('supplier_id',$data->supplier_id)->sum('previous_due');

        $return_amount = supplier_payment::where('supplier_id',$data->supplier_id)->sum('return_amount');

        $purchase_payment = supplier_payment::where('supplier_id',$data->supplier_id)->sum('payment');

        $return_paid = supplier_payment::where('supplier_id',$data->supplier_id)->sum('returnpaid');


        $grandtotal = $total_purchase - $total_discount;

        $total = ($grandtotal - $purchase_payment) + $pd;

        $subtotal = ($total - $return_amount) - $return_paid;

        // return $subtotal;


        return view('inventory.supplier_payment.payment_ledger',compact('data','subtotal'));
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
        supplier_payment::where('id',$id)->delete();
        Toastr::success('Supplier Deleted Successfully', 'Success');
        return redirect()->back();
    }

    public function getsupplierInfo($id)
    {
        $supplier = supplier_info::where('supplier_id',$id)->first();

        return view('inventory.supplier_payment.supplier_info',compact('supplier'));
    }

    public function getsupplierDue($id)
    {
        $total_purchase = purchase_ledger::where('suplier_id',$id)->sum('total');

        $total_discount = purchase_ledger::where('suplier_id',$id)->sum('discount');

        $paid = purchase_ledger::where('suplier_id',$id)->sum('paid');

        $pd = supplier_payment::where('supplier_id',$id)->sum('previous_due');

        $return_amount = supplier_payment::where('supplier_id',$id)->sum('return_amount');

        $purchase_payment = supplier_payment::where('supplier_id',$id)->sum('payment');

        $return_paid = supplier_payment::where('supplier_id',$id)->sum('returnpaid');


        $grandtotal = $total_purchase - $total_discount;

        $total = ($grandtotal - $purchase_payment) + $pd;

        $subtotal = ($total - $return_amount) - $return_paid;

        return $subtotal;
    }

    public function retrive_supplier_payment($id)
    {
        supplier_payment::where('id',$id)->restore();
        Toastr::success('Supplier Payment Retrive Successfully', 'Success');
        return redirect()->back();
    }

    public function supplier_payment_perdelete($id)
    {
        supplier_payment::where('id',$id)->withTrashed()->forceDelete();
        Toastr::success('Supplier Payment Delete Successfully', 'Success');
        return redirect()->back();
    }

    public function supplier_advance_pay()
    {
        $supplier = supplier_info::all();
        return view('inventory.supplier_payment.supplier_advance_pay',compact('supplier'));
    }
    public function supplier_loan()
    {
        $supplier = supplier_info::all();
        return view('inventory.supplier_payment.supplier_loan',compact('supplier'));
    }

    public function supplier_loan_payment(Request $request)
    {
        $payment_date = date('Y-m-d');

        // return $request->payment;

        $data = array(
            'payment_date'=>$payment_date,
            'supplier_id'=>$request->supplier_id,
            'payment'=>$request->payment * -1,
            'entry_date'=>$payment_date,
            'branch_id'=>Auth::user()->branch,
            'admin_id'=>Auth::user()->id,
        );

        supplier_payment::insert($data);

        Toastr::success('Supplier Loan Created Successfully', 'Success');
        return redirect()->back();
    }

}
