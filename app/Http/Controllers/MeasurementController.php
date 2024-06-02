<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use App\Models\product_measurement;
use Auth;

class MeasurementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = product_measurement::get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<div class="dropdown">
                    <a class="btn btn-secondary dropdown-toggle btn-sm" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a onclick="return Confirm()" class="dropdown-item" href="'.route('measurement.edit',$row->measurement_id).'"><i class="fa fa-edit"></i> Edit</a>
                        <form action="'.route('measurement.destroy',$row->measurement_id).'" method="post">
                        '.csrf_field().'
                        '.method_field("DELETE").'
                        <button onclick="return Confirm()" type="submit" class="dropdown-item text-danger"><i class="fa fa-trash"></i> Delete</button>
                        </form>
                    </div>
                </div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);


        }
        return view('inventory.measurement.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inventory.measurement.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $r)
    {
        $id = IdGenerator::generate(['table' => 'product_measurements', 'field'=>'measurement_id','length' => 10, 'prefix' =>'MU-']);


        $data = array(
            'measurement_id'       => $id,
            'measurement_sl'       => $r->measurement_sl ,
            'measurement_unit'      => $r->measurement_unit,
            'measurement_admin_id'  => Auth()->user()->id,

        );

        product_measurement::insert($data);
        Toastr::success('Measurement Unit Created', 'Success');
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
        $data = product_measurement::where('measurement_id',$id)->first();
        return view('inventory.measurement.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $r, string $id)
    {
        $data = array(
            'measurement_sl'       => $r->measurement_sl ,
            'measurement_unit'      => $r->measurement_unit,
            'measurement_admin_id'  => Auth()->user()->id,

        );

        product_measurement::where('measurement_id',$id)->update($data);
        Toastr::success('Measurement Unit Updated', 'Success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        product_measurement::where('measurement_id',$id)->delete();
        Toastr::success('Measurement Unit Deleted', 'Success');
        return redirect()->back();
    }

    public function retrive_measurement($id)
    {
        product_measurement::where('measurement_id',$id)->restore();
        Toastr::success('Measurement Unit Restored', 'Success');
        return redirect()->back();
    }

    public function measurementper_delete($id)
    {
        product_measurement::where('measurement_id',$id)->withTrashed()->forceDelete();
        Toastr::success('Measurement Unit Permenantly Deleted', 'Success');
        return redirect()->back();
    }
}
