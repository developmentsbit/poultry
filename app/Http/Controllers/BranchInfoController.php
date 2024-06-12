<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\branch_info;
use App\Models\company_info;
use DataTables;
use Auth;

class BranchInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->lang = config ("app.locale");
        $this->sl = 0;
        if ($request->ajax()) {
            $data = branch_info::all();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('sl',function($row){
                        return $this->sl = $this->sl+1;
                    })
                    ->addColumn('company_id',function($v){
                        if($v->company_id > 0)
                        {
                            $company_name = company_info::where('id',$v->company_id)->first();
                        }
                        else
                        {
                            $company_name = '-';
                        }

                        if($v->company_id > 0)
                        {
                            if($this->lang == 'en')
                            {
                                return $company_name->company_name_en;
                            }
                            elseif($this->lang == 'bn')
                            {
                                return $company_name->company_name_bn;
                            }
                        }
                        else
                        {
                            $company_name = '-';
                        }

                    })
                    ->addColumn('branch_name',function($v){
                        if($this->lang == 'en')
                        {
                            return $v->branch_name_en;
                        }
                        elseif($this->lang == 'bn')
                        {
                            return $v->branch_name_bn;
                        }
                    })
                    ->addColumn('branch_mobile',function($row){
    
                        return $row->branch_mobile;  
                    })
                    ->addColumn('branch_email',function($row){
    
                        return $row->branch_email;
                    })
                    ->addColumn('status',function($row){
                        if($row->status == 1)
                            {
                                $checked = 'checked';
                            }
                            else
                            {
                                $checked = '';
                            }
        
                            return '<input type="checkbox" id="statusChange('.$row->id.')" value="'.$row->id.'" data-switch="primary" onclick="return changeBranchStatus('.$row->id.')" '.$checked.'>
                            <label for="statusChange('.$row->id.')"></label>';
                    })
                    ->addColumn('action', function($row){
                        $btn = '<div class="dropdown">
                            <a class="btn btn-secondary dropdown-toggle btn-sm" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Actions
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a onclick="return Confirm()" class="dropdown-item" href="'.route('branch_info.edit',$row->id).'"><i class="fa fa-edit"></i> Edit</a>
                                <form action="'.route('branch_info.destroy',$row->id).'" method="post">
                                '.csrf_field().'
                                '.method_field("DELETE").'
                                <button onclick="return Confirm()" type="submit" class="dropdown-item text-danger"><i class="fa fa-trash"></i> Delete</button>
                                </form>
                            </div>
                        </div>';
                        return $btn;
                    })
                    ->rawColumns(['sl','company_id','branch_name','branch_mobile','branch_email','status','action'])
                    ->make(true);
        }
        return view('inventory.branch_info.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $company_name = company_info::all();
        return view('inventory.branch_info.create',compact('company_name'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = array(
            'company_id'=>$request->company_id,
            'branch_name_en'=>$request->branch_name_en,
            'branch_name_bn'=>$request->branch_name_bn,
            'branch_mobile'=>$request->branch_mobile,
            'branch_address_en'=>$request->branch_address_en,
            'branch_address_bn'=>$request->branch_address_bn,
            'branch_email'=>$request->branch_email,
            'official_contact_no'=>$request->official_contact_no,
            'status'=>$request->status,
        );

        branch_info::create($data);
        Toastr::success('Branch Created Successfully', 'Success');
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
        $company_name = company_info::all();

        $data = branch_info::find($id);
        $branch_id = $id;

        return view('inventory.branch_info.edit',compact('data','company_name','branch_id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = array(
            'company_id'=>$request->company_id,
            'branch_name_en'=>$request->branch_name_en,
            'branch_name_bn'=>$request->branch_name_bn,
            'branch_mobile'=>$request->branch_mobile,
            'branch_address_en'=>$request->branch_address_en,
            'branch_address_bn'=>$request->branch_address_bn,
            'branch_email'=>$request->branch_email,
            'official_contact_no'=>$request->official_contact_no,
            'status'=>$request->status,
        );

        branch_info::find($id)->update($data);
        Toastr::success('Branch Updated Successfully', 'Success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        branch_info::where('id',$id)->delete();
        Toastr::success('Brand Delete Successfully', 'Success');
        return redirect()->back();
    }


    public function changeBranchStatus(Request $request)
    {
        $find = branch_info::find($request->id);

        if($find->status == 1)
        {
            branch_info::find($request->id)->update(['status'=>0]);
        }
        else
        {
            branch_info::find($request->id)->update(['status'=>1]);
        }

        return 1;
    }

    public function retrive_branch_info($id)
    {
        branch_info::where('id',$id)->restore();
        Toastr::success('Brand Retrive Successfully', 'Success');
        return redirect()->back();
    }

    public function branch_info_per_delete($id)
    {
        branch_info::where('id',$id)->withTrashed()->forceDelete();

        Toastr::success('Brand Permanantly Delete Successfully', 'Success');
        return redirect()->back();
    }
}
