<?php

namespace App\Http\Controllers;

use App\Models\ProductMaster;
use App\Models\Conversion;
use App\Models\ProductMasterDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;


class SKUController extends Controller
{
    public function __construct() {
        $this->middleware(function ($request, $next){
            Session::put('menu_active','/sku');
            return $next($request);
        });
    }

    public function index(){
        $data = ProductMasterDetail::with('product_master')->orderBy('id','desc')->get();
        $master = ProductMaster::select('id','name')->orderBy('id','asc')->get();

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

    public function destroy(Request $request, $id)
    {
        $data = ProductMasterDetail::findOrFail($id);
        
        // periksa apakah data yang akan dihapus telah digunakan di tabel conversions
        if (Conversion::where('sku', $data->sku)->exists()) {
            return redirect()->to('/sku')->with('message', ['type' => 'danger','content' => 'Data tidak dapat dihapus']);
        } else {
            $data->delete();
            return redirect()->to('/sku')->with('message', ['type' => 'success','content' => 'Berhasil dihapus']);
        }
    }

    //update
    public function edit($id) {
        $data = ProductMasterDetail::find($id);
        if(!empty($data)){
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }else{
            return response()->json([
                'success' => false,
                'data' => []
            ]);
        }
    }
    public function update(Request $request) {
        $id = $request->id;
        if($id){
            $this->validate($request,[
                'sku' => 'required',
            ]);
            $data = ProductMasterDetail::find($id);
            $data->sku = $request->sku;
            $data->save();
            return redirect()->to('/sku')->with('message', ['type' => 'success','content' => 'Data berhasil diupdate']);
        }
    }
}
