<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Seller;
use App\Models\Sales;

class HomeController extends Controller
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
        $month = date('m'); 
        $year = date('Y'); 
        $salesmonth = Sales::whereMonth('trans_date',$month)->count();
        $salesyear = Sales::whereYear('trans_date',$year)->count();
        $sales = Sales::sum('total_tax');
        $seller = Seller::all()->count();
        $shop = Shop::all()->count();

        return view('home', compact('shop','seller','salesmonth','salesyear','sales',));
    }
    
}
