<?php

namespace App\Http\Controllers;

use App\Models\MasterColor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ColorController extends Controller
{
    public function __construct() {
        $this->middleware(function ($request, $next){
            Session::put('menu_active','color');
            return $next($request);
        });
    }

    public function index(){
        $data = MasterColor::all();

        return view('page.master.color', compact('data'));
    }
}
