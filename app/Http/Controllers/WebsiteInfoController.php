<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\website_info;
use Brian2694\Toastr\Facades\Toastr;

class WebsiteInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = website_info::find(1)->first();
        return view('inventory.website_info.index',compact('data'));
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
        $validated = $request->validate([
            'company_name'=>'required',
            'title'=>'required',
            'phone1'=>'required',
        ],
        [
            'company_name.required'=>'Please Give Company Name',
            'title.required'=>'Please Give A Title',
            'phone1.required'=>'Please Give A Phone Number',
        ]);

        $data = array(
            'company_name'=>$request->company_name,
            'title'=>$request->title,
            'phone1'=>$request->phone1,
            'email'=>$request->email,
            'adress'=>$request->adress,
            'twiiter'=>$request->twitter,
            'facebook'=>$request->facebook,
            'youtube'=>$request->youtube,
            'instagram'=>$request->instagram,
            'linkedin'=>$request->linkedin,
        );

        $update = website_info::where('id',1)->update($data);


        $logo = $request->file('logo');

        $favicon = $request->file('favicon');

        $banner = $request->file('banner');

        if($logo)
        {
            $pathImage = website_info::find(1);

            $path = base_path().'/public/WebsiteInfo/img/'.$pathImage->logo;

            if(file_exists($path))
            {
                unlink($path);
            }

            $imageName = rand().'.'.$logo->getClientOriginalExtension();

            $logo->move(base_path().'/public/WebsiteInfo/img/',$imageName);

            website_info::find(1)->update(['logo'=>$imageName]);
        }


        if($favicon)
        {
            $pathImage = website_info::find(1);

            $path = base_path().'/public/WebsiteInfo/img/'.$pathImage->favicon;

            if(file_exists($path))
            {
                unlink($path);
            }

            $imageName = rand().'.'.$favicon->getClientOriginalExtension();

            $favicon->move(base_path().'/public/WebsiteInfo/img/',$imageName);

            website_info::find(1)->update(['favicon'=>$imageName]);
        }

        if($banner)
        {
            $pathImage = website_info::find(1);

            $path = base_path().'/public/WebsiteInfo/img/'.$pathImage->banner;

            if(file_exists($path))
            {
                unlink($path);
            }

            $imageName = rand().'.'.$banner->getClientOriginalExtension();

            $banner->move(base_path().'/public/WebsiteInfo/img/',$imageName);

            website_info::find(1)->update(['banner'=>$imageName]);
        }


        if($update)
        {
            Toastr::success('Website Content Updated', 'Success');
        return redirect()->back();
        }
        else
        {
            Toastr::success('Website Content Not Updated', 'Error');
        return redirect()->back();
        }
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
        // dd($request->all());

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
