<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\customer_info;
use App\Models\supplier_info;
use App\Models\product_information;
use App\Models\current_purchase_sales;
use App\Models\measurement_subunit;
use App\Models\purchase_ledger;
use App\Models\supplier_payment;
use App\Models\sales_entry;
use App\Models\sales_ledger;
use App\Models\sales_payment;
use App\Models\purchase_entry;
use Session;
use Auth;

class PurchaseWithSales extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customer= customer_info::where('type',1)->get();
        $product = product_information::where('pdt_status',1)->get();
        $first_customer = customer_info::where('type',1)->get();
        $third_party = customer_info::where('type',3)->get();
        return view('inventory.purchase_with_sales.index',compact('customer','product','third_party','first_customer'));
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

    public function purchasesalesproduct($id)
    {
        $session_id   = Session::getId();


        $checkaddproduct = current_purchase_sales::where('current_purchase_sales.session_id',$session_id)->where('current_purchase_sales.product_id',$id)->first();

        $checkproduct = product_information::where('pdt_id',$id)->first();

        if ($checkaddproduct)
        {

            current_purchase_sales::where('product_id',$id)
            ->update([
                'product_quantity'=>$checkaddproduct->product_quantity+1,
                'final_quantity'=>$checkaddproduct->final_quantity+1,
            ]);


        }
        else
        {
            $measurement_unit = product_information::where('pdt_id',$id)->first();

            $subunit_id = measurement_subunit::where('measurement_unit_id',$measurement_unit->pdt_measurement)->first();
            current_purchase_sales::insert([
                'product_id'              => $id,
                'sub_unit_id'             => $subunit_id->id,
                'product_quantity'        => '1',
                'final_quantity'        => '1',
                'product_purchase_price'  => $checkproduct->pdt_purchase_price,
                'product_sales_price'     => $checkproduct->pdt_sale_price,
                'product_discount_amount' => 0.00,
                'session_id'              => $session_id,
                'admin_id'                => Auth()->user()->id,
            ]);

        }
    }

    public function showcurrentpurchasesales_product()
    {
        $session_id = Session::getId();

        $data = current_purchase_sales::leftjoin('product_informations','product_informations.pdt_id','current_purchase_sales.product_id')
        ->select('product_informations.pdt_name_en','product_informations.pdt_name_bn','current_purchase_sales.*','product_informations.pdt_measurement')
        ->where('current_purchase_sales.session_id',$session_id)->get();

        return view('inventory.purchase_with_sales.show_current_product',compact('data'));
    }

    public function purchasesalesqtyupdate(Request $request,$id)
    {
        // return $request->product_quantity;
        $session_id   = Session::getId();
        $data = current_purchase_sales::where('current_purchase_sales.session_id',$session_id)
        ->where('current_purchase_sales.id',$id)
        ->update([

            'product_quantity' => $request->product_quantity

        ]);
    }

    public function purchasesalessubunitupdate(Request $request,$id)
    {
        $session_id   = Session::getId();
        $data = current_purchase_sales::where('current_purchase_sales.session_id',$session_id)
        ->where('current_purchase_sales.id',$id)
        ->update([

            'sub_unit_id' => $request->sub_unit_id,

        ]);
    }
    public function purchasesalesoriginalmeasurement(Request $request,$id)
    {
        // return $id;
        $unit_data = measurement_subunit::where('id',$request->sub_unit_id)->first();

	    $result = (1 / $unit_data->sub_unit_data) * $request->product_quantity;

	    current_purchase_sales::where('id',$id)->update(['final_quantity'=>$result]);
    }

    public function purchasesalespriceupdate(Request $request,$id)
    {
        $session_id   = Session::getId();
        $data = current_purchase_sales::where('current_purchase_sales.session_id',$session_id)
        ->where('current_purchase_sales.id',$id)
        ->update([

            'product_sales_price' => $request->sale_price_per_unit

        ]);

        product_information::where('pdt_id',$request->product_id)->update([
            'pdt_sale_price'=>$request->sale_price_per_unit,
        ]);
    }
    public function purchasesalespurchasepriceupdate(Request $request,$id)
    {
        $session_id   = Session::getId();
        $data = current_purchase_sales::where('current_purchase_sales.session_id',$session_id)
        ->where('current_purchase_sales.id',$id)
        ->update([

            'product_purchase_price' => $request->purchase_price_per_unit,

        ]);

        product_information::where('pdt_id',$request->product_id)->update([
            'pdt_purchase_price'=>$request->purchase_price_per_unit,
        ]);
    }

    public function purchasesalespricediscount(Request $request,$id)
    {
        $session_id   = Session::getId();
        $data = current_purchase_sales::where('current_purchase_sales.session_id',$session_id)
        ->where('current_purchase_sales.id',$id)
        ->update([

            'product_discount_amount' => $request->product_discount_amount

        ]);
    }

    public function purchasesalesnoteupdate(Request $request,$id)
    {
        $session_id = Session::getId();

        $data = current_purchase_sales::where('current_purchase_sales.session_id',$session_id)
        ->where('current_purchase_sales.id',$id)
        ->update([

            'note' => $request->note,

        ]);
    }

    public function deletepurchase_sales_product($id)
    {
        $session_id   = Session::getId();
        $data = current_purchase_sales::where('current_purchase_sales.session_id',$session_id)
        ->where('current_purchase_sales.id',$id)
        ->delete();
    }

    public function submitpurchasesales(Request $request)
    {
        // dd($request->all());

        $session_id   = Session::getId();
        $data = current_purchase_sales::where('current_purchase_sales.session_id',$session_id)
        ->get();

        $invoice_no1 = IdGenerator::generate(['table' => 'purchase_ledgers', 'field'=>'invoice_no','length' => 10, 'prefix' =>'PI-']);

        foreach($data as $d)
        {
            purchase_entry::insert([
                'invoice_no'        => $invoice_no1,
                'product_id'        => $d->product_id,
                'sub_unit_id'       => $d->sub_unit_id,
                'product_quantity'  => $d->final_quantity,
                'purchase_price'    => $d->product_purchase_price,
                'discount_amount'   => $d->product_discount_amount,
                'admin_id'          => Auth()->user()->id,
                'branch_id'         => Auth()->user()->branch,
            ]);
        }

        $explode = explode('/',$request->invoice_date);
        $invoice_date = $explode[2].'-'.$explode[0].'-'.$explode[1];


       purchase_ledger::insert([
            'invoice_no'       => $invoice_no1,
            'voucher_no'       => $request->voucher_no,
            'voucher_date'     => $invoice_date,
            'invoice_date'     => $invoice_date,
            'suplier_id'       => $request->customer_id,
            'total'            => $request->totalpurchaseamount,
            'paid'             => $request->totalpurchaseamount,
            'discount'         => $request->purchase_discount,
            'transaction_type' => $request->transaction_type,
            'entry_date'       => date('Y-m-d'),
            'admin_id'         => Auth()->user()->id,
            'branch_id'        => Auth()->user()->branch,
            'comment'=>'purchase_with_sales',
            'ledger_type'=>'pws',


        ]);


        sales_payment::insert([
            'invoice_no'       => $invoice_no1,
            'entry_date'       => date('Y-m-d'),
            'customer_id'      => $request->customer_id,
            'return_amount'    => "0.00",
            'payment_amount'   => $request->totalpurchaseamount,
            'payment_type'     => $request->transaction_type,
            'note'          => "purchasewithsales",
            'admin_id'         => Auth()->user()->id,
            'branch_id'        => Auth()->user()->branch,
        ]);


        $invoice_no2 = IdGenerator::generate(['table' => 'sales_ledgers', 'field'=>'invoice_no','length' => 10, 'prefix' =>'SI-']);

        foreach ($data as $d) {
            sales_entry::insert([
                 'invoice_no'                 => $invoice_no2,
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

        }

        sales_ledger::insert([
            'invoice_no'       => $invoice_no2,
            'invoice_date'     => $invoice_date,
            'customer_id'      => $request->third_party,
            'total'            => $request->totalamountsales,
            'vat'              => $request->vat,
            'paid_amount'      => '0.00',
            'final_discount'   => $request->sales_discount,
            'transaction_type' => $request->transaction_type,
            'entry_date'       => date('Y-m-d'),
            'admin_id'         => Auth()->user()->id,
            'branch_id'        => Auth()->user()->branch,

        ]);


        sales_payment::insert([
            'invoice_no'       => $invoice_no2,
            'entry_date'       => date('Y-m-d'),
            'customer_id'      => $request->third_party,
            'payment_amount'   => '0.00',
            'payment_type'     => $request->transaction_type,
            'note'             => "third_party",
            'admin_id'         => Auth()->user()->id,
            'branch_id'        => Auth()->user()->branch,


        ]);


        current_purchase_sales::where('session_id',$session_id)->delete();
        Session::regenerate();

        Toastr::success('Purchase With Sales Created', 'Success');
        return redirect()->back();
    }
}
