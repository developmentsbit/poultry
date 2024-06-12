<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use App\Models\customer_info;
use App\Models\current_sales;
use App\Models\stock;
use App\Models\product_information;
use App\Models\measurement_subunit;
use App\Models\sales_ledger;
use App\Models\sales_entry;
use App\Models\sales_payment;
use App\Models\current_sales_return;
use App\Models\product_measurement;
use Auth;
use Session;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = sales_ledger::leftjoin('customer_infos','customer_infos.customer_id','sales_ledgers.customer_id')
            ->select('sales_ledgers.*','customer_infos.customer_name_en','customer_infos.customer_phone')
            ->where('sales_ledgers.branch_id',Auth::user()->branch)
            ->get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('customer_info',function($row){
                return $row->customer_name_en.'<br>'.$row->customer_phone;
            })
            ->addColumn('product_info',function($row){
                // return $row->invoice_no;
                $product = sales_entry::where('invoice_no',$row->invoice_no)
                ->leftjoin('product_informations','product_informations.pdt_id','sales_entries.product_id')
                ->leftjoin('measurement_subunits','measurement_subunits.id','sales_entries.sub_unit_id')
                ->select('sales_entries.*','product_informations.pdt_name_en','measurement_subunits.sub_unit_name')
                ->get();



                $output = '';

                if($product)
                {
                    foreach($product as $p)
                    {
                        $totalcost = $p->product_sales_price - $p->product_discount_amount;

                        $subtotal = $p->product_quantity * $totalcost;

                        $returntotal = $p->return_quantity * $totalcost;



                        $output .=  '<b>'.$p->pdt_name_en.'</b> ('.$p->product_quantity.' '.$p->sub_unit_name.' X '.$totalcost.' tk) = '.$subtotal.' tk';
                        $output .='<br>';

                    }

                    foreach($product as $p)
                    {
                        if($p->return_quantity != 0)
                        {

                            $output.= '<br>
                            Return : <br><b>'.$p->pdt_name_en.'</b> ('.$p->return_quantity.' '.$p->sub_unit_name.' X '.$totalcost.' tk) = '.$returntotal.' tk <br>';
                        }
                    }
                }

                return $output;
            })
            ->addColumn('amount',function($row){

                $sales_entry = sales_entry::where('invoice_no',$row->invoice_no)->get();

                $sales_payment = sales_payment::where('invoice_no',$row->invoice_no)->sum('payment_amount');

                $sales_returnamount = sales_payment::where('invoice_no',$row->invoice_no)->sum('return_amount');

                $sales_returnpayment = sales_payment::where('invoice_no',$row->invoice_no)->sum('returnpaid');


                $total = 0;
                if($sales_entry)
                {
                    foreach($sales_entry as $p)
                    {
                        $totalcost = $p->product_sales_price  - $p->product_discount_amount;
                        $total = ($total+($p->product_quantity * $totalcost));
                    }
                }

                $grandtotal = $total - $row->final_discount;


                $total_transaction = ($grandtotal - $sales_payment) - $sales_returnamount;
                $total_due = $total_transaction - $sales_returnpayment;



                return 'Total : '.$total.' tk<br>
                        Discount: '.$row->final_discount.' tk<br>
                        Grand Total: '.$grandtotal.' tk<br>
                        <span class="badge bg-success">Paid : '.$sales_payment.' tk</span><br>
                        <span class="badge bg-warning">Return : '.$row->return_amount.' tk</span><br>
                        <span class="badge bg-info">Return Paid : '.$sales_returnpayment.' tk</span><br>
                        <span class="badge bg-danger">Due : '.$total_due.' tk</span><br>';
            })
            ->addColumn('action', function($row){
                $btn = '<div class="dropdown">
                    <a class="btn btn-secondary dropdown-toggle btn-sm" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a target="_blank" class="dropdown-item" href="'.url('sales_invoice/'.$row->invoice_no).'"><i class="fa fa-eye"></i> Show Invoice</a>
                        <a target="_blank" class="dropdown-item" href="'.url('sales_invoicea4/'.$row->invoice_no).'"><i class="fa fa-eye"></i> Show A4 Invoice</a>
                        <a target="" class="dropdown-item" href="'.url('sales_return/'.$row->invoice_no).'"><i class="fa fa-arrow-left"></i> Return</a>
                        <form action="'.route('sales.destroy',$row->invoice_no).'" method="post">
                        '.csrf_field().'
                        '.method_field("DELETE").'
                        <button onclick="return Confirm()" type="submit" class="dropdown-item text-danger"><i class="fa fa-trash"></i> Delete</button>
                        </form>
                    </div>
                </div>';
                return $btn;
            })
            ->rawColumns(['action','customer_info','product_info','amount'])
            ->make(true);


        }
        return view('inventory.sales.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customer = customer_info::where('type',1)->get();
        $product = stock::leftjoin("product_informations",'product_informations.pdt_id','stocks.product_id')
        ->where('stocks.branch_id',Auth::user()->branch)
        ->select("stocks.*",'product_informations.pdt_id','product_informations.pdt_name_en','product_informations.pdt_name_bn')
        ->get();
        return view('inventory.sales.create',compact('customer','product'));
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
        $chkq = sales_entry::withTrashed()->where('invoice_no',$id)->get();
        if($chkq)
        {
            foreach($chkq as $v)
            {
                $total_stock = stock::where('product_id',$v->product_id)->first();
                // return $total_stock->sales_qty;
                $returnqty = sales_entry::where('invoice_no',$id)->where('product_id',$v->product_id)->sum('return_quantity');

                $updated_quantity = ($total_stock->sales_qty - $v->product_quantity) - $returnqty;

                // return $updated_quantity;
                stock::where('product_id',$v->product_id)->update([
                    'sales_qty'=> $updated_quantity,
                ]);
            }
        }

        sales_entry::where('invoice_no',$id)->delete();
        sales_ledger::where('invoice_no',$id)->delete();
        sales_payment::where('invoice_no',$id)->delete();
        Toastr::success('Sales Ledger Ledger Delete Successfully', 'Success');
        return redirect()->back();
    }

    public function salesproductcart($id)
    {
        $session_id   = Session::getId();
        $checkproduct = stock::where('stocks.product_id',$id)
        ->leftjoin("product_informations","product_informations.pdt_id","stocks.product_id")
        ->select("stocks.*","product_informations.pdt_measurement")
        ->first();


        $checkaddproduct = current_sales::where('current_sales.session_id',$session_id)->where('current_sales.product_id',$id)->first();

        if ($checkaddproduct)
        {

            current_sales::where('product_id',$id)
            ->update([
                'product_quantity'=>$checkaddproduct->product_quantity+1,
                'final_quantity'=>$checkaddproduct->product_quantity+1
            ]);


        }
        else
        {

            $measurement_unit = product_information::where('pdt_id',$id)->first();

            $subunit_id = measurement_subunit::where('measurement_unit_id',$measurement_unit->pdt_measurement)->first();

            current_sales::insert([
                'product_id'              => $id,
                'sub_unit_id'             => $subunit_id->id,
                'product_quantity'        => '1',
                'final_quantity'        => '1',
                'product_purchase_price'  => $checkproduct->purchase_price_withcost,
                'product_sales_price'     => $checkproduct->sale_price,
                'product_discount_amount' => 0.00,
                'session_id'              => $session_id,
                'admin_id'                => Auth()->user()->id,
            ]);

        }
    }
    public function salesproductcart2($id)
    {
        $session_id   = Session::getId();
        $product = product_information::where('barcode',$id)->first();

        // return $product->pdt_id;

        $checkproduct = stock::where('stocks.product_id',$product->pdt_id)
        ->leftjoin("product_informations","product_informations.pdt_id","stocks.product_id")
        ->select("stocks.*","product_informations.pdt_measurement")
        ->first();


        $checkaddproduct = current_sales::where('current_sales.session_id',$session_id)->where('current_sales.product_id',$product->pdt_id)->first();

        if ($checkaddproduct)
        {

            current_sales::where('product_id',$product->pdt_id)
            ->update([
                'product_quantity'=>$checkaddproduct->product_quantity+1
            ]);


        }
        else
        {

            current_sales::insert([
                'product_id'              => $product->pdt_id,
                'sub_unit_id'             => NULL,
                'product_quantity'        => '1',
                'product_purchase_price'  => $checkproduct->purchase_price_withcost,
                'product_sales_price'     => $checkproduct->sale_price,
                'product_discount_amount' => 0.00,
                'session_id'              => $session_id,
                'admin_id'                => Auth()->user()->id,
            ]);

        }
    }

    public function showsalesproductcart()
    {
        $session_id   = Session::getId();
        $data = current_sales::where('current_sales.session_id',$session_id)
        ->join('product_informations','product_informations.pdt_id','current_sales.product_id')
        ->select('current_sales.*','product_informations.pdt_name_en','product_informations.pdt_name_bn','product_informations.pdt_sale_price','product_informations.pdt_measurement','product_informations.pdt_id')
        ->get();

        return view('inventory.sales.showsalesproductcart',compact('data'));
    }

    public function qtyupdatesales(Request $request,$id)
    {
        $session_id   = Session::getId();
        $data = current_sales::where('current_sales.session_id',$session_id)
        ->where('current_sales.id',$id)
        ->update([

            'product_quantity' => $request->product_quantity,
            'final_quantity' => $request->product_quantity,

        ]);
    }

    public function note_update(Request $request,$id)
    {
        $session_id = Session::getId();

        $data = current_sales::where('current_sales.session_id',$session_id)
        ->where('current_sales.id',$id)
        ->update([

            'note' => $request->note,

        ]);
    }

    public function salessubmeasurmentupdate(Request $request,$id)
    {
        $session_id   = Session::getId();
        $data = current_sales::where('current_sales.session_id',$session_id)
        ->where('current_sales.id',$id)
        ->update([

            'sub_unit_id' => $request->sub_unit_id,

        ]);
    }

    public function salepriceupdatesingle(Request $request,$id)
    {
        $session_id   = Session::getId();
        $data = current_sales::where('current_sales.session_id',$session_id)
        ->where('current_sales.id',$id)
        ->update([

            'product_sales_price' => $request->sale_price_per_unit

        ]);

        product_information::where('pdt_id',$request->product_id)->update([
            'pdt_sale_price'=>$request->sale_price_per_unit,
        ]);
    }

    public function product_discount_amount(Request $request,$id)
    {
        $session_id   = Session::getId();
        $data = current_sales::where('current_sales.session_id',$session_id)
        ->where('current_sales.id',$id)
        ->update([

            'product_discount_amount' => $request->product_discount_amount

        ]);
    }

    public function deletesalescartproduct($id)
    {
        $session_id   = Session::getId();
        $data = current_sales::where('current_sales.session_id',$session_id)
        ->where('current_sales.id',$id)
        ->delete();
    }

    public function salesOriginalMeasurement(Request $request,$id)
    {
        // return $id;
        $unit_data = measurement_subunit::where('id',$request->sub_unit_id)->first();

	    $result = (1 / $unit_data->sub_unit_data) * $request->product_quantity;

	    current_sales::where('id',$id)->update(['final_quantity'=>$result]);
    }

    public function salesledger(Request $request)
    {
        $session_id   = Session::getId();
            $data = current_sales::where('current_sales.session_id',$session_id)
            ->get();

            $invoice_no = IdGenerator::generate(['table' => 'sales_ledgers', 'field'=>'invoice_no','length' => 10, 'prefix' =>'SI-']);



            foreach ($data as $d) {
               sales_entry::insert([
                    'invoice_no'                 => $invoice_no,
                    'product_id'                 => $d->product_id,
                    'sub_unit_id'                => $d->sub_unit_id,
                    'product_quantity'           => $d->final_quantity,
                    'product_purchase_price'     => $d->product_purchase_price,
                    'product_sales_price'        => $d->product_sales_price,
                    'product_discount_amount'    => $d->product_discount_amount,
                    'note'                       => $d->note,
                    'entry_date'                 => date('Y-m-d'),
                    'admin_id'                   => Auth()->user()->id,
                    'branch_id'                  => Auth()->user()->branch,


                ]);

                $checkstockproduct =  stock::where("product_id",$d->product_id)->where("branch_id",Auth()->user()->branch)->first();
                $qtysum            =  stock::where("product_id",$d->product_id)->where("branch_id",Auth()->user()->branch)->sum("sales_qty");

                stock::where("product_id",$d->product_id)
                ->where("branch_id",Auth()->user()->branch)
                ->update([
                    "sales_qty" => $qtysum + $d->final_quantity
                ]);

            }



            $explode = explode('/',$request->invoice_date);
            $invoice_date = $explode[2].'-'.$explode[0].'-'.$explode[1];


            sales_ledger::insert([
                'invoice_no'       => $invoice_no,
                'invoice_date'     => $invoice_date,
                'customer_id'      => $request->customer_id,
                'total'            => $request->totalamount,
                'vat'              => $request->vat,
                'paid_amount'      => $request->paid,
                'final_discount'   => $request->discount,
                'transaction_type' => $request->transaction_type,
                'entry_date'       => date('Y-m-d'),
                'admin_id'         => Auth()->user()->id,
                'branch_id'        => Auth()->user()->branch,

            ]);


            sales_payment::insert([
                'invoice_no'       => $invoice_no,
                'entry_date'       => date('Y-m-d'),
                'customer_id'      => $request->customer_id,
                'payment_amount'   => $request->paid,
                'payment_type'     => $request->transaction_type,
                'note'             => "firstpayment",
                'admin_id'         => Auth()->user()->id,
                'branch_id'        => Auth()->user()->branch,


            ]);


            current_sales::where('session_id',$session_id)->delete();
            Session::regenerate();



            return response()->json($invoice_no);
    }

    public function sales_invoice($invoice_no)
    {
        $data = sales_ledger::where("sales_ledgers.invoice_no",$invoice_no)
        ->join("customer_infos",'customer_infos.customer_id','sales_ledgers.customer_id')
        ->join("users",'users.id','sales_ledgers.admin_id')
        ->select("sales_ledgers.*",'customer_infos.customer_name_en','customer_infos.customer_phone','customer_infos.customer_address','users.name')
        ->first();

        $product = sales_entry::where("sales_entries.invoice_no",$data->invoice_no)
        ->join("product_informations",'product_informations.pdt_id','sales_entries.product_id')
        ->select('sales_entries.*','product_informations.pdt_measurement','product_informations.pdt_name_en','product_informations.pdt_name_bn')
        ->get();

        return view("inventory.sales.sales_invoice",compact('data','product'));
    }
    public function sales_invoicea4($invoice_no)
    {
        $data = sales_ledger::where("sales_ledgers.invoice_no",$invoice_no)
        ->join("customer_infos",'customer_infos.customer_id','sales_ledgers.customer_id')
        ->join("users",'users.id','sales_ledgers.admin_id')
        ->select("sales_ledgers.*",'customer_infos.customer_name_en','customer_infos.customer_phone','customer_infos.customer_address','users.name')
        ->first();

        $product = sales_entry::where("sales_entries.invoice_no",$data->invoice_no)
        ->join("product_informations",'product_informations.pdt_id','sales_entries.product_id')
        ->select('sales_entries.*','product_informations.pdt_measurement','product_informations.pdt_name_en','product_informations.pdt_name_bn')
        ->get();

        return view("inventory.sales.sales_invoicea4",compact('data','product'));
    }

    public function retrive_sales_ledger($id)
    {
        $chkq = sales_entry::withTrashed()->where('invoice_no',$id)->get();
        if($chkq)
        {
            foreach($chkq as $v)
            {
                $total_stock = stock::where('product_id',$v->product_id)->first();
                // return $total_stock->sales_qty;
                $updated_quantity = $total_stock->sales_qty + $v->product_quantity;
                // return $updated_quantity;
                stock::where('product_id',$v->product_id)->update([
                    'sales_qty'=> $updated_quantity,
                ]);
            }
        }

        sales_entry::where('invoice_no',$id)->restore();
        sales_ledger::where('invoice_no',$id)->restore();
        sales_payment::where('invoice_no',$id)->restore();
        Toastr::success('Sales Ledger Ledger Retrive Successfully', 'Success');
        return redirect()->back();
    }

    public function deleteper_salesledger($id)
    {
        sales_entry::where('invoice_no',$id)->forceDelete();
        sales_ledger::where('invoice_no',$id)->forceDelete();
        sales_payment::where('invoice_no',$id)->forceDelete();
        Toastr::success('Sales Ledger Ledger Permanently Delete Successfully', 'Success');
        return redirect()->back();
    }

    public function sales_return($id)
    {

        $check = current_sales_return::where('invoice_no',$id)->delete();

        $sales_entry = sales_entry::where('invoice_no',$id)->get();

        if($sales_entry)
        {
            foreach($sales_entry as $p)
            {
                $qty = $p->product_quantity - $p->return_quantity;
                current_sales_return::insert([
                    'invoice_no'              => $p->invoice_no,
                    'product_id'              => $p->product_id,
                    'sub_unit_id'             => $p->sub_unit_id,
                    'product_quantity'        => $qty,
                    'product_sales_price'     => $p->product_sales_price,
                    'product_discount_amount' => $p->product_discount_amount,
                    'admin_id'                => Auth()->user()->id,
                ]);
            }
        }

        $data = sales_ledger::where('invoice_no',$id)->leftjoin('customer_infos','customer_infos.customer_id','sales_ledgers.customer_id')
                ->select('sales_ledgers.*','customer_infos.customer_name_en','customer_infos.customer_phone')
                ->first();

        return view('inventory.sales.sales_return',compact('data'));
    }


    public function load_current_salesreturn(Request $request)
    {
        // return $request->invoice_no;
        $products = current_sales_return::where('invoice_no',$request->invoice_no)
        ->leftjoin('product_informations','product_informations.pdt_id','current_sales_returns.product_id')
        ->leftjoin('product_measurements','product_measurements.measurement_id','product_informations.pdt_measurement')
        ->select('current_sales_returns.*','product_informations.pdt_name_en','product_measurements.measurement_unit')
        ->get();
        $i = 1;

        $invoice_no = $request->invoice_no;

        return view('inventory.sales.current_sales_return',compact('products','i','invoice_no'));
    }

    public function delete_current_sales_return($id)
    {
        current_sales_return::where('id',$id)->delete();
    }

    public function current_sales_returnqty_update(Request $request,$id)
    {
        current_sales_return::where('id',$id)->update([
            'product_quantity'=>$request->qty,
        ]);
    }

    public function sales_return_submit(Request $request)
    {
        // dd($request->all());
        $data = current_sales_return::where('invoice_no',$request->invoice_no)->get();

        // dd($data);

        if($data)
        {
            foreach($data as $v)
            {
                $previous_returnqty = sales_entry::where('invoice_no',$v->invoice_no)->where('product_id',$v->product_id)->sum('return_quantity');

                $final_returnqty = $previous_returnqty + $v->product_quantity;

                sales_entry::where('invoice_no',$v->invoice_no)->where('product_id',$v->product_id)->update([
                    'return_quantity' => $final_returnqty,
                ]);

                $totalsalesqty = stock::where('product_id',$v->product_id)->sum('sales_qty');

                $grandtotalsales_qty = $totalsalesqty - $v->product_quantity;

                stock::where('product_id',$v->product_id)->update([
                    'sales_qty'=>$grandtotalsales_qty,
                ]);
            }
        }

        $previous_returnamount = sales_payment::where('invoice_no',$request->invoice_no)->sum('return_amount');

        $final_returnamount = $previous_returnamount + $request->totalamount;

        sales_ledger::where('invoice_no',$request->invoice_no)->update(['return_amount'=>$final_returnamount]);


        sales_payment::where('invoice_no',$request->invoice_no)->update([
            'return_amount'=>$final_returnamount,
        ]);

        $row = sales_ledger::where('invoice_no',$request->invoice_no)->first();

        $sales_entry = sales_entry::where('invoice_no',$row->invoice_no)->get();

        $sales_payment = sales_payment::where('invoice_no',$row->invoice_no)->sum('payment_amount');

        $sales_returnpayment = sales_payment::where('invoice_no',$row->invoice_no)->sum('return_amount');

        $total = 0;
        if($sales_entry)
        {
            foreach($sales_entry as $p)
            {
                $totalcost = $p->product_sales_price  - $p->product_discount_amount;
                $total = ($total+($p->product_quantity * $totalcost));
            }
        }

        $grandtotal = $total - $row->final_discount;


        $total_due = ($grandtotal - $sales_payment) - $sales_returnpayment;

        if($total_due > 0)
        {
            sales_payment::where('invoice_no',$row->invoice_no)->update([
                'returnpaid'=>'0',
            ]);

        }
        else
        {
            sales_payment::where('invoice_no',$row->invoice_no)->update([
                'returnpaid'=>$total_due,
            ]);
        }




        current_sales_return::where('invoice_no',$request->invoice_no)->delete();

        Toastr::success('Sales Return Successfully', 'Success');
        return redirect('/sales');


    }
}
