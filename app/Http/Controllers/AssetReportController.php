<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\asset_category;
use App\Models\asset_invest;
use App\Models\asset_cost;
use App\Traits\Date;

class AssetReportController extends Controller
{
    protected $path;
    public function __construct()
    {
        $this->path = 'inventory.asset_report';
    }

    public function path($blade, $param1 = NULL, $param2 = NULL)
    {
        $data = $param1;
        $title = $param2;

        return view($this->path.'.'.$blade,compact('data','title'));
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = asset_category::all();
        return $this->path('index',NULL,$title);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function show_asset_report(Request $request)
    {
        $data = [];
        $data['title_id'] = $request->title_id;
        $data['report_type'] = $request->report_type;
        if($request->report_type == 'Daily')
        {
            $data['search_date'] = $request->date;
        }
        elseif($request->report_type == 'Monthly')
        {
            $monthName = Date::getMonthName($request->month);
            $data['search_date'] = 'Month : '.$monthName.' || Year : '.$request->year;
            $data['month'] = $request->month;
            $data['year'] = $request->year;
        }
        else{

            $data['search_date'] = $request->year;
            $data['year'] = $request->year;
        }

        if($request->title_id == 'all')
        {
            $data['title'] = asset_category::with('invest','withdraw')->get();
        }
        else
        {
            $data['title_name'] = asset_category::find($data['title_id'])->select('title_en')->first();
            if($request->report_type == 'Daily')
            {

                $data['invests'] = asset_invest::where('title_id',$request->title_id)->where('date',Date::DateToDb('/',$request->date))->get();
                $data['withdraw'] =asset_cost::where('title_id',$request->title_id)->where('date',Date::DateToDb('/',$request->date))->get();
            }
            elseif($request->report_type == 'Monthly')
            {
                $data['invests'] = asset_invest::where('title_id',$request->title_id)
                ->whereMonth('date',$request->month)
                ->whereYear('date',$request->year)
                ->get();
                $data['withdraw'] = asset_cost::where('title_id',$request->title_id)
                ->whereMonth('date',$request->month)
                ->whereYear('date',$request->year)
                ->get();
            }
            else
            {
                $data['invests'] = asset_invest::where('title_id',$request->title_id)
                ->whereYear('date',$request->year)
                ->get();
                $data['withdraw'] = asset_cost::where('title_id',$request->title_id)
                ->whereYear('date',$request->year)
                ->get();
            }
        }

        // dd($data);

        return $this->path('show_report',$data,NULL);
    }
}
