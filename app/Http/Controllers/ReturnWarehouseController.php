<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\ReturnWarehouse;
use App\Http\Repository\ReturnWarehouseRepository;

class ReturnWarehouseController extends Controller
{
    protected $returnWarehouse, $conversionRepository, $DetailReturnWarehouseRepository;
    
    public function __construct(ReturnWarehouseRepository $return) {
        $this->ReturnWarehouseRepository = $return;
        $this->middleware(function ($request, $next){
            Session::put('menu_active','returnwarehouse');
            return $next($request);
        });
    }

    public function index(){
        $data = $this->ReturnWarehouseRepository->get_data_all();

        return view('page.returnwarehouse', compact('data'));
    }

    public function show($id) {
        $data = $this->ReturnWarehouseRepository->get_data_by_id($id);
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

    public function confirm($id, Request $request){
        $type = $request->type;
        if($type == "open"){
            ReturnWarehouse::find($id)->update(['status'=>'open']);
        }
        return response()->json([
            'success' => true,
            'message' => 'Status Berhasil Diubah!',
        ]); 

    }
}
