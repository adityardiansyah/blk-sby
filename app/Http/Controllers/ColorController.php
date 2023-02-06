<?php

namespace App\Http\Controllers;

use App\Models\MasterColor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ColorController extends Controller
{
    public function __construct() {
        Session::put('menu_active','color');
    }

    public function index(){
        $data = MasterColor::all();

        return view('page.master.color', compact('data'));
    }
}
