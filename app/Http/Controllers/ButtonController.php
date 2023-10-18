<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Repository\ButtonRepository;

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

        return view('page.master.aksi', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);

        $this->button->store($request);

        return response()->json([
            'success' => TRUE,
            'message' => 'Berhasil menambah data!'
        ]);
    }
}
