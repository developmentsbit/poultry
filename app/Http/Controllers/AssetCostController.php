<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\asset_category;
use App\Traits\Date;
use App\Models\asset_cost;
use Brian2694\Toastr\Facades\Toastr;

class AssetCostController extends Controller
{
    protected $path;
    use Date;
    public function __construct()
    {
        $this->path = 'inventory.asset_cost';
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = asset_cost::with('title')->get();
        $i = 1;
        return view($this->path.'.index',compact('data','i'));
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
        $date = Date::DateToDb('/',$request->date);
        $data = array(
            'date' => $date,
            'title_id' => $request->title_id,
            'amount' => $request->amount,
        );
        asset_cost::create($data);
        Toastr::success('Asset Cost Created', 'Success');
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
        $category = asset_category::where('status',1)->get();
        $data = asset_cost::find($id);
        return view($this->path.'.edit',compact('category','data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $date = Date::DateToDb('/',$request->date);
        $data = array(
            'date' => $date,
            'title_id' => $request->title_id,
            'amount' => $request->amount,
        );
        asset_cost::find($id)->update($data);
        Toastr::success('Asset Cost Updated', 'Success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        asset_cost::find($id)->delete();
        Toastr::success('Asset Cost Deleted', 'Success');
        return redirect()->back();
    }

    public function restore($id)
    {
        asset_cost::withTrashed()->where('id',$id)->restore();
        Toastr::success('Asset Cost Restored', 'Success');
        return redirect()->back();
    }
    public function delete($id)
    {
        asset_cost::withTrashed()->where('id',$id)->forceDelete();
        Toastr::success('Asset Cost Deleted Permenantly', 'Success');
        return redirect()->back();
    }
}
