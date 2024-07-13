<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\asset_category;
use App\Models\asset_invest;
use App\Models\asset_cost;
use App\Traits\Date;
use Brian2694\Toastr\Facades\Toastr;
use Auth;

class AssetInvestController extends Controller
{
    protected $path;
    public function __construct()
    {
        $this->path = 'inventory.asset_invest';
    }
    public function path($view, $pass = NULL, $pass2 = NULL)
    {
        $title = $pass2;
        $data = $pass;
        return view($this->path.'.'.$view,compact('title','data'));
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = asset_invest::where('branch_id',Auth::user()->branch)->with('title')->get();
        return $this->path('index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = asset_category::where('status',1)->get();
        return $this->path('create','',$title);
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
            'comment' => $request->comment,
            'branch_id' => Auth::user()->branch,
        );

        asset_invest::create($data);
        Toastr::success('Asset Invest Created', 'Success');
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
        $data = asset_invest::find($id);
        $title = asset_category::all();
        return $this->path('edit',$data,$title);
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
            'comment' => $request->comment,
        );

        asset_invest::find($id)->update($data);
        Toastr::success('Asset Invest Updated', 'Success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        asset_invest::find($id)->delete();
        Toastr::success('Asset Invest Deleted', 'Success');
        return redirect()->back();
    }

    public function restore(string $id)
    {
        asset_invest::where('id',$id)->withTrashed()->restore();
        Toastr::success('Asset Invest Restored', 'Success');
        return redirect()->back();
    }

    public function delete(string $id)
    {
        asset_invest::where('id',$id)->withTrashed()->forceDelete();
        Toastr::success('Asset Invest Deleted', 'Success');
        return redirect()->back();
    }

    public function cash_asset()
    {
        return view('inventory.cash_asset.create');
    }

    public function cash_asset_store(Request $request)
    {
        // return $request;
        $date = Date::DateToDb('/',$request->date);
        $data = array(
            'date' => $date,
            'title_id' => 2,
            'amount' => $request->amount,
            'comment' => $request->comment,
            'branch_id' => Auth::user()->branch,
        );

        asset_invest::create($data);
        Toastr::success('Cash Asset Invest Created', 'Success');
        return redirect()->back();
    }

    public function cash_asset_index()
    {

    }
}
