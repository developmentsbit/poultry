<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use App\Models\measurement_subunit;
use App\Models\product_measurement;
use Auth;

class MeasurementSubUnit extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = measurement_subunit::leftjoin('product_measurements','product_measurements.measurement_id','measurement_subunits.measurement_unit_id')
            ->select('measurement_subunits.*','product_measurements.measurement_unit')
            ->get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<div class="dropdown">
                    <a class="btn btn-secondary dropdown-toggle btn-sm" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a onclick="return Confirm()" class="dropdown-item" href="'.route('measurement_subunit.edit',$row->id).'"><i class="fa fa-edit"></i> Edit</a>
                        <form action="'.route('measurement_subunit.destroy',$row->id).'" method="post">
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
        return view('inventory.measurement_subunit.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $measurment = product_measurement::get();
        return view('inventory.measurement_subunit.create',compact('measurment'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $r)
    {
        $data = array(
            'measurement_unit_id'      => $r->measurement_unit_id,
            'sub_unit_name'            => $r->sub_unit_name,
            'sub_unit_data'            => $r->sub_unit_data,
            'admin_id'=>Auth::user()->id,
        );
        measurement_subunit::insert($data);
        Toastr::success('Measurement Sub Unit Created', 'Success');
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
        $measurment = product_measurement::get();
        $data = measurement_subunit::find($id);
        return view('inventory.measurement_subunit.edit',compact('measurment','data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $r, string $id)
    {
        $data = array(
            'measurement_unit_id'      => $r->measurement_unit_id,
            'sub_unit_name'            => $r->sub_unit_name,
            'sub_unit_data'            => $r->sub_unit_data,
            'admin_id'=>Auth::user()->id,
        );
        measurement_subunit::find($id)->update($data);
        Toastr::success('Measurement Sub Unit Updated', 'Success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        measurement_subunit::find($id)->delete();
        Toastr::success('Measurement Sub Unit Deleted', 'Success');
        return redirect()->back();
    }

    public function retrive_subunit($id)
    {
        measurement_subunit::where('id',$id)->restore();
        Toastr::success('Measurement Sub Unit Restored', 'Success');
        return redirect()->back();
    }

    public function subunit_per_delete($id)
    {
        measurement_subunit::where('id',$id)->withTrashed()->forceDelete();
        Toastr::success('Measurement Sub Unit Permenantly Deleted', 'Success');
        return redirect()->back();
    }
}
