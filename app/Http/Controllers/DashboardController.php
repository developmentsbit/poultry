<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\customer_info;
use App\Models\supplier_info;
use App\Models\purchase_ledger;
use App\Models\sales_ledger;
use App\Models\product_information;
use App\Models\income_entry;
use App\Models\expense_entry;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $total_customer = customer_info::count();
        $total_suppliers = supplier_info::count();
        $total_purchase = purchase_ledger::count();
        $total_sales = sales_ledger::count();
        $total_product = product_information::count();
        $total_income = income_entry::count();
        $total_expense = expense_entry::count();
        return view('dashboard',compact('total_customer','total_suppliers','total_purchase','total_sales','total_product','total_income','total_expense'));
    }
}
