<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\purchase_ledger;
use App\Models\supplier_payment;
use App\Models\stock;
use App\Models\purchase_entry;
use App\Models\product_information;
use App\Models\supplier_info;
use Auth;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use GetDate;

class PurchaseReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = supplier_payment::leftjoin('supplier_infos','supplier_infos.supplier_id','supplier_payments.supplier_id')
            ->where('supplier_payments.payment','=',NULL)
            ->where('supplier_payments.comment','!=','PD')
            ->select('supplier_payments.*','supplier_infos.supplier_name_en','supplier_infos.supplier_address')
            ->get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('return_date',function($row){
                return GetDate::getDate($row->payment_date,'-');
            })
            ->addColumn('supplier_info',function($row){
                return $row->supplier_name_en.','.$row->supplier_address;
            })
            ->addColumn('product_info',function($row){
                $data = purchase_entry::leftjoin('product_informations','product_informations.pdt_id','purchase_entries.product_id')
                ->leftjoin('product_measurements','product_measurements.measurement_id','product_informations.pdt_measurement')
                ->where('purchase_entries.invoice_no',$row->invoice_no)
                ->where('purchase_entries.return_quantity','!=',NULL)
                ->where('purchase_entries.status',$row->id)
                ->select('purchase_entries.*','product_informations.pdt_name_en','product_measurements.measurement_unit')
                ->first();

                return $data->pdt_name_en.' ('. $data->return_quantity .' '.$data->measurement_unit.' * '. $data->purchase_price.' )';
            })
            ->addColumn('amount',function($row){
                $data = purchase_entry::leftjoin('product_informations','product_informations.pdt_id','purchase_entries.product_id')
                ->where('purchase_entries.invoice_no',$row->invoice_no)
                ->where('purchase_entries.return_quantity','!=',NULL)
                ->where('purchase_entries.status',$row->id)
                ->select('purchase_entries.*','product_informations.pdt_name_en')
                ->first();

                return $data->return_quantity * $data->purchase_price;
            })
            ->addColumn('action',function($row){
                $btn ='';
                $btn .='
                <a target="_blank" class="btn btn-info btn-sm" href="'.route('purchase_return.show',$row->id).'">Show Return Invoice</a>
                ';

                return $btn;
            })
            ->rawColumns(['return_date','supplier_info','product_info','amount','action'])
            ->make(true);


        }
        return view('inventory.purchase_return.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $product = purchase_entry::leftjoin('product_informations','product_informations.pdt_id','purchase_entries.product_id')
        ->select('product_informations.pdt_name_en','product_informations.pdt_id')
        ->groupBy('product_informations.pdt_id')
        ->get();
        return view('inventory.purchase_return.create',compact('product'));
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
        $data = supplier_payment::leftjoin('supplier_infos','supplier_infos.supplier_id','supplier_payments.supplier_id')
            ->where('supplier_payments.payment','=',NULL)
            ->where('supplier_payments.comment','!=','PD')
            ->where('supplier_payments.id',$id)
            ->select('supplier_payments.*','supplier_infos.supplier_name_en','supplier_infos.supplier_address')
            ->first();
        $purchase_entry = purchase_entry::leftjoin('product_informations','product_informations.pdt_id','purchase_entries.product_id')
        ->leftjoin('product_measurements','product_measurements.measurement_id','product_informations.pdt_measurement')
        ->where('purchase_entries.invoice_no',$data->invoice_no)
        ->where('purchase_entries.return_quantity','!=',NULL)
        ->where('purchase_entries.status',$data->id)
        ->select('purchase_entries.*','product_informations.pdt_name_en','product_measurements.measurement_unit')
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

        return view('inventory.purchase_return.show',compact('data','purchase_entry','subtotal'));
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

    public function getProductPurchaseDetails(Request $request)
    {
        // return $request->pdt_id;
        $data = purchase_entry::join('purchase_ledgers','purchase_ledgers.invoice_no','purchase_entries.invoice_no')
                ->join('supplier_infos','supplier_infos.supplier_id','purchase_ledgers.suplier_id')
                ->join('product_informations','product_informations.pdt_id','purchase_entries.product_id')
                ->join('product_measurements','product_measurements.measurement_id','product_informations.pdt_measurement')
                ->where('purchase_entries.product_id',$request->pdt_id)
                ->where('purchase_entries.product_quantity','!=',NULL)
                ->select('supplier_infos.supplier_name_en','supplier_infos.supplier_id','purchase_entries.*','purchase_ledgers.invoice_date','product_measurements.measurement_unit')
                ->get();

        return view('inventory.purchase_return.showpurchase_details',compact('data'));
    }

    public function purchase_returns($invoice_id,$product_id)
    {
        // return $invoice_id;
        $data = [];
        $data['purchase_ledger'] = purchase_ledger::where('invoice_no',$invoice_id)->first();
        $data['purchase_entries'] = purchase_entry::join('product_informations','product_informations.pdt_id','purchase_entries.product_id')
        ->where('purchase_entries.invoice_no',$invoice_id)
        ->where('purchase_entries.product_id',$product_id)
        ->where('purchase_entries.product_quantity','!=',NULL)
        ->select('purchase_entries.*','product_informations.pdt_name_en')
        ->first();
        $data['supplier'] = supplier_info::where('supplier_id',$data['purchase_ledger']->suplier_id)->first();
        // return $data['supplier'];
        return view('inventory.purchase_return.purchase_returns',compact('data'));
    }

    public function submitPurchaseReturnForm(Request $request,$invoice_id)
    {
        // dd($request->all());
        $payment_date = date('Y-m-d');
        $insert_sp = supplier_payment::create([
            'invoice_no'=>$invoice_id,
            'payment_date'=>date('Y-m-d'),
            'return_amount'=>$request->grandtotal,
            'comment'=>'purchase_return',
            'admin_id'=>Auth::user()->id,
            'supplier_id'=>$request->supplier_id,
        ]);
        purchase_entry::create([
            'invoice_no'=>$invoice_id,
            'product_id'=>$request->product_id,
            'purchase_price'=>$request->price_per_unit,
            'return_quantity'=>$request->return_quantity,
            'entry_date'=>date('Y-m-d'),
            'admin_id'=>Auth::user()->id,
            'status' =>$insert_sp->id,
        ]);

        $previous_purchase_return = stock::where('product_id',$request->product_id)->sum('purchase_return_qty');

        stock::where('product_id',$request->product_id)->update([
            'purchase_return_qty'=>$previous_purchase_return + $request->return_quantity,
        ]);



        Toastr::success('Product Return To Supplier Successfully', 'Success');
        return redirect('/purchase_return');
    }
}
