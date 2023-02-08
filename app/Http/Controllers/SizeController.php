<?php

namespace App\Http\Controllers;

use App\Models\MasterSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SizeController extends Controller
{
    public function __construct() {
        $this->middleware(function ($request, $next){
            Session::put('menu_active','size');
            return $next($request);
        });
    }

    public function index(){
        $data = MasterSize::all();

        return view('page.master.size', compact('data'));
    }
}
