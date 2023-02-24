<?php

namespace App\Http\Controllers;

use App\Models\ProductMaster;
use App\Models\ProductMasterDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class SKUController extends Controller
{
    public function __construct() {
        $this->middleware(function ($request, $next){
            Session::put('menu_active','sku');
            return $next($request);
        });
    }

    public function index(){
        $data = ProductMasterDetail::with('product_master')->orderBy('id','desc')->get();
        $master = ProductMaster::orderBy('id','asc')->get();

        return view('page.master.sku', compact('data','master'));
    }

    public function store(Request $request)
    {
        try {
            $check = ProductMasterDetail::where('sku',$request->sku)->first();
            if(empty($check)){
                ProductMasterDetail::create($request->all());
                $arr = [
                    'success' => true,
                    'message' => 'Berhasil ditambahkan!' 
                ];
            }else{
                $arr = [
                    'success' => false,
                    'message' => 'SKU sudah ada!' 
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

    public function list_sku()
    {
        $output = '';

        $data = ProductMasterDetail::with('product_master')->orderBy('id','desc')->get();
        foreach ($data as $key => $value) {
            $output .= View::make('components.sku')
                        ->with('item', $value)
                        ->with('key', $key)
                        ->render();
        }
        if (count($data) > 0)
            return response()->json([
                'html' => $output
            ]);
        else
            return '<tr><td colspan="3"></td></tr>';
    }
}
