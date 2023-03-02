<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ShopController extends Controller
{
    public function __construct() {
        $this->middleware(function ($request, $next){
            Session::put('menu_active','shop');
            return $next($request);
        });
    }

    public function index()
    {
        $data = Shop::all();
        return view('page.shop', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            // return $request->all();
            $check = Shop::where('name',$request->name)->first();
            if(empty($check)){
                $request->merge(['status'=>'active']) ;

                Shop::create($request->all());

                $arr = [
                    'success' => true,
                    'message' => 'Berhasil ditambahkan!' 
                ];
            }else{
                $arr = [
                    'success' => false,
                    'message' => 'Toko sudah ada!' 
                ];
            }
            return response()->json($arr);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal ditambahkan!' 
            ]);
        }
    //     $request->validate([
    //         'nama_toko' => 'required|unique:toko'
    //     ]);
    //     Shop::create($data);
    //     if ($validator->fails()) {
    //         return redirect('tambah-toko')
    //                     ->withErrors($validator)
    //                     ->withInput();
    //     }
    //     $toko = new Shop;
    //     $toko->nama_toko = $request->nama_toko;
    //     $toko->save();
    //     return redirect()->to('/shop')->with('message', ['type' => 'success', 'content' => 'Berhasil ditambahkan']);
        
    // }
    }
}
