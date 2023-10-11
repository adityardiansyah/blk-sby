<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use App\Models\MasterColor;
use App\Models\Conversion;
use Illuminate\Support\Facades\DB;

class ColorController extends Controller
{
    public function __construct() {
        $this->middleware(function ($request, $next){
            Session::put('menu_active','/color');
            return $next($request);
        });
    }

    public function index(){
        $data = MasterColor::all();
        $data = MasterColor::orderBy('id','desc')->get();

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

    // public function destroy($id)
    // {
    //     $data = MasterColor::find($id);
    //     $data ->delete();
    //     return redirect()->to('/color')->with('message', ['type' => 'success','content' => 'Berhasil dihapus']);
    // }

    public function destroy(Request $request, $id)
    {
        $data = MasterColor::findOrFail($id);
        
        // periksa apakah data yang akan dihapus telah digunakan di tabel conversions
        if (Conversion::where('color', $data->name)->exists()) {
            return redirect()->to('/color')->with('message', ['type' => 'danger','content' => 'Data tidak dapat dihapus']);
        } else {
            $data->delete();
            return redirect()->to('/color')->with('message', ['type' => 'success','content' => 'Berhasil dihapus']);
        }
    }
}

