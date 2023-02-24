<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use App\Models\MasterColor;

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

    public function store(Request $request)
    {
        try {
            $check = MasterColor::where('name',$request->name)->first();
            if(empty($check)){
                MasterColor::create($request->all());
                $arr = [
                    'success' => true,
                    'message' => 'Berhasil ditambahkan!' 
                ];
            }else{
                $arr = [
                    'success' => false,
                    'message' => 'Warna sudah ada!' 
                ];
            }
            return response()->json($arr);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal ditambahkan!' 
            ]);
        }
    }

    public function destroy($id)
    {
        $data = MasterColor::find($id);
        $data ->delete();
        return redirect()->to('/color')->with('message', ['type' => 'success','content' => 'Berhasil dihapus']);
        
        }
}
