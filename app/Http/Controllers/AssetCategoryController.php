<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\asset_category;

class AssetCategoryController extends Controller
{
    protected $path;
    public function __construct()
    {
        $this->path = 'inventory.asset_category';
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = asset_category::all();
        return view($this->path.'.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view($this->path.'.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = array(
            'title_en' => $request->title_en,
            'title_bn' => $request->title_bn,
            'status' => $request->status,
        );
        asset_category::create($data);
        Toastr::success('Asset Category Created', 'Success');
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
        $data = asset_category::find($id);
        return view($this->path.'.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = array(
            'title_en' => $request->title_en,
            'title_bn' => $request->title_bn,
            'status' => $request->status,
        );
        asset_category::find($id)->update($data);
        Toastr::success('Asset Category Updated', 'Success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        asset_category::find($id)->delete();
        Toastr::success('Asset Category Deleted', 'Success');
        return redirect()->back();
    }

    public function restore($id)
    {
        asset_category::withTrashed()->where('id',$id)->restore();
        Toastr::success('Asset Category Restored', 'Success');
        return redirect()->back();
    }

    public function delete($id)
    {
        asset_category::withTrashed()->where('id',$id)->forceDelete();
        Toastr::success('Asset Category Deleted Permenantly', 'Success');
        return redirect()->back();
    }

    public function status($id)
    {
        $check = asset_category::withTrashed()->where('id',$id)->first();
        if($check->status == 1)
        {
            asset_category::inactive($id);
        }
        else{
            asset_category::active($id);
        }

        return 1;
    }
}
