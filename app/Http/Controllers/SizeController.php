<?php

namespace App\Http\Controllers;

use App\Models\MasterSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SizeController extends Controller
{
    public function __construct() {
        Session::put('menu_active','size');
    }

    public function index(){
        $data = MasterSize::all();

        return view('page.master.size', compact('data'));
    }
}
