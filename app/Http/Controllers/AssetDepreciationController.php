<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\asset_category;
use App\Models\asset_depreciation;

class AssetDepreciationController extends Controller
{
    protected $path;
    public function __construct()
    {
        $this->path = 'inventory.asset_depreciation';
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = asset_depreciation::with('title')->get();
        return view($this->path.'.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = asset_category::where('status',1)->get();
        return view($this->path.'.create',compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = array(
            'title_id' => $request->title_id,
            'depreciation_value' => $request->depreciation_value,
            'details' => $request->details,
        );

        asset_depreciation::create($data);
        Toastr::success('Asset Depreciation Created', 'Success');
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
        $data = asset_depreciation::find($id);
        $category = asset_category::where('status',1)->get();
        return view($this->path.'.edit',compact('data','category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = array(
            'title_id' => $request->title_id,
            'depreciation_value' => $request->depreciation_value,
            'details' => $request->details,
        );

        asset_depreciation::find($id)->update($data);
        Toastr::success('Asset Depreciation Updated', 'Success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        asset_depreciation::find($id)->delete();
        Toastr::success('Asset Depreciation Deleted', 'Success');
        return redirect()->back();
    }

    public function restore($id)
    {
        asset_depreciation::withTrashed()->where('id',$id)->restore();
        Toastr::success('Asset Depreciation Restored', 'Success');
        return redirect()->back();
    }


    public function delete($id)
    {
        asset_depreciation::withTrashed()->where('id',$id)->forceDelete();
        Toastr::success('Asset Depreciation Deleted', 'Success');
        return redirect()->back();
    }
}
