<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\company_info;
use Brian2694\Toastr\Facades\Toastr;

class SoftwaresettingControllers extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = company_info::first();
        return view('inventory.softwaresetting.index',compact('data'));
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
    public function update(Request $r, $id)
    {
        $data = array(
            'company_name_en'    => $r->company_name_en,
            'company_name_bn'    => $r->company_name_bn,
            'company_mobile'     => $r->company_mobile,
            'company_address_en' => $r->company_address_en,
            'company_address_bn' => $r->company_address_bn,
            'company_email'      => $r->company_email,
            'status'             => $r->status,
            'vat'                => $r->vat,
            'openingbalance'     => $r->openingbalance,
            'status'             => 1,
        );

        $file1 = $r->file('logo');

        if($file1)
        {
            $imageName = rand().'.'.$file1->getClientOriginalExtension();

            $file1->move(base_path().'/public/inventory/logo/',$imageName);

            $data['logo'] = $imageName;
        }

        $file2 = $r->file('banner');

        if($file2)
        {
            $imageName = rand().'.'.$file2->getClientOriginalExtension();

            $file2->move(base_path().'/public/inventory/banner/',$imageName);

            $data['banner'] = $imageName;
        }

        $update = company_info::find($id)->update($data);

        if($update)
        {
            Toastr::success('Company Information Updated', 'Success');
            return redirect()->back();
        }
        else
        {
            Toastr::error('Company Information Upate Failed', 'Error');
            return redirect()->back();
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
