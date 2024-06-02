<?php

namespace App\Http\Controllers\Member;

use App\Helpers\SmsHelper;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:member');
    }

    public function path($page)
    {
        return view('member-views.' . $page);
    }

    public function index()
    {
        return $this->path('dashboard');
    }


    public function profile()
    {
        return $this->path('profile');
    }

}