<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repository\ButtonRepository;
use Illuminate\Support\Facades\Session;

class ButtonController extends Controller
{
    protected $button;
    public function __construct(ButtonRepository $button) {

        $this->button = $button;
        $this->middleware(function ($request, $next){
            Session::put('menu_active','/button');
            return $next($request);
        });
    }
    
    public function index()
    {
        $data = $this->button->button();

        return view('page.master.button', compact('data'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'name' => 'required',
            'position' => 'required',
        ]);

        $this->button->update($request);

        return response()->json([
            'success' => TRUE,
            'message' => 'Berhasil merubah data!'
        ]);
    }
}
