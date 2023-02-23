<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ConversionController extends Controller
{
    public function __construct() {
        $this->middleware(function ($request, $next){
            Session::put('menu_active','conversion');
            return $next($request);
        });
    }

    public function index()
    {
        return view('page.conversion');
    }
}
