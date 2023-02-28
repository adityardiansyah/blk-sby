<?php

namespace App\Http\Controllers;

use App\Models\MasterSize;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
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

    public function destroy($id)
    {
        $data = MasterSize::find($id);
        $data ->delete();
        return redirect()->to('/size')->with('message', ['type' => 'success','content' => 'Berhasil dihapus']);
        
        }

    public function store(Request $request)
        {
            try {
                $check = MasterSize::where('name',$request->name)->first();
                if(empty($check)){
                    MasterSize::create($request->all());
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
    
    
}
