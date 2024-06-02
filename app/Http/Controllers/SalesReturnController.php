<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\sales_payment;
use App\Models\sales_entry;
use App\Models\customer_info;
use App\Models\stock;
use App\Models\product_information;
use App\Models\sales_ledger;
use Auth;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use GetDate;

class SalesReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = sales_payment::leftjoin('customer_infos','customer_infos.customer_id','sales_payments.customer_id')
            ->where('sales_payments.payment_amount','=',NULL)
            ->where('sales_payments.note','!=','PD')
            ->select('sales_payments.*','customer_infos.customer_name_en','customer_infos.customer_address')
            ->get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('return_date',function($row){
                return GetDate::getDate($row->entry_date,'-');
            })
            ->addColumn('customer_info',function($row){
                return $row->customer_name_en.','.$row->customer_address;
            })
            ->addColumn('product_info',function($row){
                $data = sales_entry::leftjoin('product_informations','product_informations.pdt_id','sales_entries.product_id')
                ->leftjoin('product_measurements','product_measurements.measurement_id','product_informations.pdt_measurement')
                ->where('sales_entries.invoice_no',$row->invoice_no)
                ->where('sales_entries.return_quantity','!=',NULL)
                ->where('sales_entries.status',$row->id)
                ->select('sales_entries.*','product_informations.pdt_name_en','product_measurements.measurement_unit')
                ->first();

                return $data->pdt_name_en.' ('. $data->return_quantity .' '.$data->measurement_unit.' * '. $data->product_sales_price.' )';
            })
            ->addColumn('amount',function($row){
                $data = sales_entry::leftjoin('product_informations','product_informations.pdt_id','sales_entries.product_id')
                ->where('sales_entries.invoice_no',$row->invoice_no)
                ->where('sales_entries.return_quantity','!=',NULL)
                ->where('sales_entries.status',$row->id)
                ->select('sales_entries.*','product_informations.pdt_name_en')
                ->first();

                return $data->return_quantity * $data->product_sales_price;
            })
            ->addColumn('action',function($row){
                $btn ='';
                $btn .='
                <a target="_blank" class="btn btn-info btn-sm" href="'.route('sales_return.show',$row->id).'">Show Return Invoice</a>
                ';

                return $btn;
            })
            ->rawColumns(['return_date','customer_info','product_info','amount','action'])
            ->make(true);


        }
        return view('inventory.sales_return.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $product = sales_entry::leftjoin('product_informations','product_informations.pdt_id','sales_entries.product_id')
        ->select('product_informations.pdt_name_en','product_informations.pdt_id')
        ->groupBy('product_informations.pdt_id')
        ->get();

        return view('inventory.sales_return.create',compact('product'));
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
        $data = sales_payment::leftjoin('customer_infos','customer_infos.customer_id','sales_payments.customer_id')
            ->where('sales_payments.payment_amount','=',NULL)
            ->where('sales_payments.note','!=','PD')
            ->where('sales_payments.id',$id)
            ->select('sales_payments.*','customer_infos.customer_name_en','customer_infos.customer_address')
            ->first();
        $sales_entry = sales_entry::leftjoin('product_informations','product_informations.pdt_id','sales_entries.product_id')
        ->leftjoin('product_measurements','product_measurements.measurement_id','product_informations.pdt_measurement')
        ->where('sales_entries.invoice_no',$data->invoice_no)
        ->where('sales_entries.return_quantity','!=',NULL)
        ->where('sales_entries.status',$data->id)
        ->select('sales_entries.*','product_informations.pdt_name_en','product_measurements.measurement_unit')
        ->first();

    $total_sales = sales_ledger::where('customer_id',$data->customer_id)->sum('total');

    $total_discount = sales_ledger::where('customer_id',$data->customer_id)->sum('final_discount');

    $paid = sales_ledger::where('customer_id',$data->customer_id)->sum('paid_amount');

    $pd = sales_payment::where('customer_id',$data->customer_id)->sum('previous_due');

    $return_amount = sales_payment::where('customer_id',$data->customer_id)->sum('return_amount');

    $sales_payment = sales_payment::where('customer_id',$data->customer_id)->sum('payment_amount');

    $return_paid = sales_payment::where('customer_id',$data->customer_id)->sum('returnpaid');


    $grandtotal = $total_sales - $total_discount;

    $total = ($grandtotal - $sales_payment) + $pd;

    $subtotal = ($total - $return_amount) - $return_paid;

        return view('inventory.sales_return.show',compact('data','sales_entry','subtotal'));
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

    public function getSalesDetails(Request $request)
    {
        $data = sales_entry::join('sales_ledgers','sales_ledgers.invoice_no','sales_entries.invoice_no')
                ->join('customer_infos','customer_infos.customer_id','sales_ledgers.customer_id')
                ->join('product_informations','product_informations.pdt_id','sales_entries.product_id')
                ->join('product_measurements','product_measurements.measurement_id','product_informations.pdt_measurement')
                ->where('sales_entries.product_id',$request->pdt_id)
                ->where('sales_entries.product_quantity','!=',NULL)
                ->select('customer_infos.customer_name_en','customer_infos.customer_id','sales_entries.*','sales_ledgers.invoice_date','product_measurements.measurement_unit')
                ->get();
        return view('inventory.sales_return.show_sales_details',compact('data'));
    }

    public function sales_returns($invoice_no,$product_id)
    {
        $data =[];
        $data['sales_ledger'] = sales_ledger::where('invoice_no',$invoice_no)->first();
        $data['customer'] = customer_info::where('customer_id',$data['sales_ledger']->customer_id)->first();
        $data['sales_entries'] = sales_entry::join('product_informations','product_informations.pdt_id','sales_entries.product_id')
        ->where('sales_entries.invoice_no',$invoice_no)
        ->where('sales_entries.product_id',$product_id)
        ->where('sales_entries.product_quantity','!=',NULL)
        ->select('sales_entries.*','product_informations.pdt_name_en')
        ->first();
        return view('inventory.sales_return.sales_return',compact('data'));
    }

    public function submitSalesReturnForm(Request $request,$invoice_no)
    {
        // dd($request->all());
        if($request->return_quantity > 0)
        {
            $insert = sales_payment::create([
                'invoice_no'=>$invoice_no,
                'entry_date'=>date('Y-m-d'),
                'return_amount'=>$request->grandtotal,
                'note'=>'sales_return',
                'admin_id'=>Auth::user()->id,
                'customer_id'=>$request->customer_id,
            ]);

            sales_entry::create([
                'invoice_no'=>$invoice_no,
                'product_id'=>$request->product_id,
                'product_sales_price'=>$request->price_per_unit,
                'return_quantity'=>$request->return_quantity,
                'entry_date'=>date('Y-m-d'),
                'admin_id'=>Auth::user()->id,
                'status' =>$insert->id,
            ]);

            $previous_sales_return = stock::where('product_id',$request->product_id)->sum('sales_return_qty');

            stock::where('product_id',$request->product_id)->update([
                'sales_return_qty'=>$previous_sales_return + $request->return_quantity,
            ]);
            Toastr::success('Customer Product Return Successfully', 'Success');
            return redirect()->back();
        }
        else
        {
            Toastr::error('Customer Product Return Unsuccessfully', 'Error');
            return redirect()->back();
        }

    }
}
