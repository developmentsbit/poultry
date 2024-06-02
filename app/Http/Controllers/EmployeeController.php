<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use Auth;
use App\Models\employee_info;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = employee_info::get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('contact',function($row){
                return '<span>Phone: '.$row->phone.'</span><br>
                <span>Email: '.$row->email.'</span><br>
                <span>Adress: '.$row->address.'</span>';
            })
            ->addColumn('image',function($row){
                $path = public_path().'/inventory/employee_image/'.$row->image;

                if(file_exists($path))
                {
                    $btn = '<a target="_blank" class="btn btn-sm btn-info" href="'.asset("/inventory/employee_image/$row->image").'">View Image</a>';
                }
                else
                {
                    $btn = '';
                }
                return $btn;
            })
            ->addColumn('nid_image',function($row){
                $path = public_path().'/inventory/employee_nid/'.$row->nid_image;

                if(file_exists($path))
                {

                    $btn = '<a target="_blank" class="btn btn-sm btn-success" href="'.asset("/inventory/employee_nid/$row->nid_image").'">View NID</a>';
                }
                else
                {
                    $btn = '';
                }
                return $btn;
            })
            ->addColumn('action', function($row){
                $btn = '<div class="dropdown">
                    <a class="btn btn-secondary dropdown-toggle btn-sm" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a onclick="return Confirm()" class="dropdown-item" href="'.route('employee.edit',$row->id).'"><i class="fa fa-edit"></i> Edit</a>
                        <form action="'.route('employee.destroy',$row->id).'" method="post">
                        '.csrf_field().'
                        '.method_field("DELETE").'
                        <button onclick="return Confirm()" type="submit" class="dropdown-item text-danger"><i class="fa fa-trash"></i> Delete</button>
                        </form>
                    </div>
                </div>';
                return $btn;
            })
            ->rawColumns(['action','image','contact','nid_image'])
            ->make(true);


        }
        return view('inventory.employee.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inventory.employee.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $data = array(
            "name" => $request->name,
            "phone" => $request->phone,
            "email" => $request->email,
            "nid_no" => $request->nid_no,
            "joining_date" => $request->joining_date,
            "address" => $request->address,
            'image'=>'0',
            'nid_image'=>'0',
        );

        $image = $request->file('image');

        if($image)
        {
            $imageName = rand().'.'.$image->getClientOriginalExtension();

            $image->move(public_path().'/inventory/employee_image/',$imageName);

            $data['image'] = $imageName;
        }

        $nid_image = $request->file('nid_image');

        if($nid_image)
        {
            $imageName = rand().'.'.$nid_image->getClientOriginalExtension();

            $nid_image->move(public_path().'/inventory/employee_nid/',$imageName);

            $data['nid_image'] = $imageName;
        }

        employee_info::create($data);

        Toastr::success('Employee Information Created', 'Success');
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
        $data = employee_info::find($id);
        return view('inventory.employee.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = array(
            "name" => $request->name,
            "phone" => $request->phone,
            "email" => $request->email,
            "nid_no" => $request->nid_no,
            "joining_date" => $request->joining_date,
            "address" => $request->address,
        );

        $image = $request->file('image');

        if($image)
        {
            $pathImage = employee_info::find($id);

            $path = public_path().'/inventory/employee_image/'.$pathImage->image;

            if(file_exists($path))
            {
                unlink($path);
            }
        }

        if($image)
        {
            $imageName = rand().'.'.$image->getClientOriginalExtension();

            $image->move(public_path().'/inventory/employee_image/',$imageName);

            $data['image'] = $imageName;
        }

        $nid_image = $request->file('nid_image');

        if($nid_image)
        {
            $pathImage = employee_info::find($id);

            $path = public_path().'/inventory/employee_nid/'.$pathImage->nid_image;

            if(file_exists($path))
            {
                unlink($path);
            }
        }

        if($nid_image)
        {
            $imageName = rand().'.'.$nid_image->getClientOriginalExtension();

            $nid_image->move(public_path().'/inventory/employee_nid/',$imageName);

            $data['nid_image'] = $imageName;
        }

        employee_info::find($id)->update($data);

        Toastr::success('Employee Information Updated', 'Success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        employee_info::find($id)->delete();
        Toastr::success('Employee Information Deleted', 'Success');
        return redirect()->back();
    }

    public function retrive_employee($id)
    {
        employee_info::where('id',$id)->withTrashed()->restore();
        Toastr::success('Employee Information Restored', 'Success');
        return redirect()->back();
    }

    public function employee_per_delete($id)
    {
        employee_info::where('id',$id)->withTrashed()->forceDelete();
        Toastr::success('Employee Information Deleted', 'Success');
        return redirect()->back();
    }
}
