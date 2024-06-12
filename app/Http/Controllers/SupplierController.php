<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use App\Models\supplier_info;
use App\Models\supplier_payment;
use App\Models\purchase_ledger;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = supplier_info::get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('supplier_details',function($row){
                return '<b>'.$row->supplier_name_en.'</b><br>
                <span>'.$row->supplier_phone.'</span><br>
                <span>'.$row->supplier_email.'</span>';
            })
            ->addColumn('company_details',function($row){
                return '<b>'.$row->supplier_company_name.'</b><br>
                <span>'.$row->supplier_company_phone.'</span><br>
                <span>'.$row->supplier_company_address.'</span>';
            })
            ->addColumn('acounts',function($row){
                $total_purchase = purchase_ledger::where('suplier_id',$row->supplier_id)->sum('total');

                $total_discount = purchase_ledger::where('suplier_id',$row->supplier_id)->sum('discount');

                $paid = purchase_ledger::where('suplier_id',$row->supplier_id)->sum('paid');

                $pd = supplier_payment::where('supplier_id',$row->supplier_id)->sum('previous_due');

                $return_amount = supplier_payment::where('supplier_id',$row->supplier_id)->sum('return_amount');

                $purchase_payment = supplier_payment::where('supplier_id',$row->supplier_id)->where('payment' , '>', 0)->sum('payment');

                $return_paid = supplier_payment::where('supplier_id',$row->supplier_id)->sum('returnpaid');

                $discount = supplier_payment::where('supplier_id',$row->supplier_id)->sum('discount');

                $supplier_loans = supplier_payment::where('supplier_id',$row->supplier_id)->where('payment','<',0)->sum('payment');

                $loans = $supplier_loans * -1;


                $grandtotal = $total_purchase - $total_discount;

                $total = (($grandtotal - $purchase_payment) + $pd ) - $discount;

                $subtotal = ($total - $return_amount) - $return_paid + $loans ;


                return '<span class="badge bg-danger">'.$subtotal.'</span>';
            })
            ->addColumn('action', function($row){
                $btn = '<div class="dropdown">
                    <a class="btn btn-secondary dropdown-toggle btn-sm" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a target="_blank" onclick="return Confirm()" class="dropdown-item" href="'.route('supplier.show',$row->supplier_id).'"><i class="fa fa-eye"></i> View Detials</a>
                        <a onclick="return Confirm()" class="dropdown-item" href="'.route('supplier.edit',$row->supplier_id).'"><i class="fa fa-edit"></i> Edit</a>
                        <form action="'.route('supplier.destroy',$row->supplier_id).'" method="post">
                        '.csrf_field().'
                        '.method_field("DELETE").'
                        <button onclick="return Confirm()" type="submit" class="dropdown-item text-danger"><i class="fa fa-trash"></i> Delete</button>
                        </form>
                    </div>
                </div>';
                return $btn;
            })
            ->rawColumns(['action','company_details','supplier_details','acounts'])
            ->make(true);


        }
        return view('inventory.supplier.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inventory.supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $r)
    {
        $id = IdGenerator::generate(['table' => 'supplier_infos', 'field'=>'supplier_id','length' => 7, 'prefix' =>'S-']);


        if ($r->previous_due > 0 && $r->previous_due != Null) {


            $data = array(
                'supplier_id'              => $id,
                'supplier_branch_id'       => $r->supplier_branch_id,
                'supplier_name_en'         => $r->supplier_name_en,
                'supplier_name_bn'         => $r->supplier_name_bn,
                'supplier_email'           => $r->supplier_email,
                'supplier_phone'           => $r->supplier_phone,
                'supplier_address'         => $r->supplier_address,
                'supplier_company_name'    => $r->supplier_company_name,
                'supplier_company_phone'   => $r->supplier_company_phone,
                'supplier_company_address' => $r->supplier_company_address,
                'supplier_admin_id'        => Auth()->user()->id,

            );

            supplier_info::insert($data);
            $data2 = array([

                'payment_date' => date('Y-m-d'),
                'entry_date'   => date('Y-m-d'),
                'previous_due' => $r->previous_due,
                'supplier_id'   => $id,
                'comment'      => "PD",
                'branch_id'    => Auth()->user()->branch,
                'admin_id'     => Auth()->user()->id,


            ]);
            supplier_payment::insert($data2);
        }else{
            $data = array(
                'supplier_id'              => $id,
                'supplier_branch_id'       => $r->supplier_branch_id,
                'supplier_name_en'         => $r->supplier_name_en,
                'supplier_name_bn'         => $r->supplier_name_bn,
                'supplier_email'           => $r->supplier_email,
                'supplier_phone'           => $r->supplier_phone,
                'supplier_address'         => $r->supplier_address,
                'supplier_company_name'    => $r->supplier_company_name,
                'supplier_company_phone'   => $r->supplier_company_phone,
                'supplier_company_address' => $r->supplier_company_address,
                'supplier_admin_id'        => Auth()->user()->id,

            );

            supplier_info::insert($data);


        }

        Toastr::success('Supplier Created', 'Success');
        return redirect()->back();

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = [];
        $data['supplier'] = supplier_info::where('supplier_id',$id)->first();
        $data['previous_due'] = supplier_payment::where('supplier_id',$id)->where('comment','PD')->sum('previous_due');
        $data['supplier_payment'] = supplier_payment::where('supplier_id',$id)->orderBy('payment_date','ASC')->get();

        $data['sl'] = 1;

        // return  $data['supplier_payment'];
        return view('inventory.supplier.show',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = supplier_info::where('supplier_id',$id)->first();
        $pd = supplier_payment::where('supplier_id',$id)->where('comment','PD')->first();

        if($pd)
        {
            $previous_due = $pd->previous_due;
        }
        else
        {
            $previous_due = 0;
        }
        return view('inventory.supplier.edit',compact('data','previous_due'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $r, string $id)
    {
        $data = array(
            'supplier_branch_id' => $r->supplier_branch_id,
            'supplier_name_en'   => $r->supplier_name_en,
            'supplier_name_bn'   => $r->supplier_name_bn,
            'supplier_email'     => $r->supplier_email,
            'supplier_phone'     => $r->supplier_phone,
            'supplier_address'   => $r->supplier_address,
            'supplier_company_name'    => $r->supplier_company_name,
            'supplier_company_address' => $r->supplier_company_address,
            'supplier_company_phone'   => $r->supplier_company_phone,
            'supplier_admin_id'  => Auth()->user()->id,
            'supplier_branch_id' => Auth()->user()->branch,
        );
        supplier_info::where('supplier_id',$id)->update($data);

        if($r->previous_due == 0 && $r->previous_due == Null)
        {
            supplier_payment::withTrashed()->where('supplier_id',$id)->where('comment','PD')->forceDelete();
        }

        if ($r->previous_due > 0 && $r->previous_due != Null)
        {
            supplier_payment::withTrashed()->where('supplier_id',$id)->where('comment','PD')->forceDelete();

            $data2 = array([

                'payment_date' => date('Y-m-d'),
                'entry_date'   => date('Y-m-d'),
                'previous_due' => $r->previous_due,
                'supplier_id'   => $id,
                'comment'      => "PD",
                'branch_id'    => Auth()->user()->branch,
                'admin_id'     => Auth()->user()->id,


            ]);
            supplier_payment::insert($data2);

        }


        Toastr::success('Supplier Updated', 'Success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        supplier_info::where('supplier_id',$id)->delete();
        supplier_payment::where('supplier_id',$id)->delete();
        Toastr::success('Supplier Information Removed', 'Success');
        return redirect()->back();
    }

    public function retrive_supplier($id)
    {
        supplier_payment::where('supplier_id',$id)->restore();
        supplier_info::where('supplier_id',$id)->restore();
        Toastr::success('Supplier Retrive', 'Success');
        return redirect()->back();
    }

    public function supplierper_delete($id)
    {
        supplier_payment::withTrashed()->where('supplier_info',$id)->forceDelete();
        supplier_info::withTrashed()->where('supplier_info',$id)->forceDelete();
        Toastr::success('Supplier Permenantly Delete Successfullly', 'Success');
        return redirect()->back();
    }
}
