<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ShopController extends Controller
{
    public function __construct() {
        $this->middleware(function ($request, $next){
            Session::put('menu_active','shop');
            return $next($request);
        });
    }

    public function index()
    {
        $data = Shop::all();
        return view('page.shop', compact('data'));
    }
}
