<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\GoodsReceive;
use App\Http\Repository\GoodsReceiveRepository;
use App\Http\Repository\ManagementStockRepository;

class GoodsReceiveController extends Controller
{
    protected $goodsReceiveRepository, $detailGoodsReceiveRepository, $conversionRepository, $manageStockRepository;
    
    public function __construct(GoodsReceiveRepository $goods, ManagementStockRepository $manageStock) {
        $this->goodsReceiveRepository = $goods;
        $this->manageStockRepository = $manageStock;

        $this->middleware(function ($request, $next){
            Session::put('menu_active','/goodsreceive');
            return $next($request);
        });
    }

    public function index(){
        $data = $this->goodsReceiveRepository->get_data_all();

        return view('page.goodsreceive', compact('data'));
    }

    public function show($id) {
        $data = $this->goodsReceiveRepository->get_data_by_id($id);
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
            return $this->manageStockRepository->update_status($id, $type);
        }
        return response()->json([
            'success' => true,
            'message' => 'Status Berhasil Diubah!',
        ]); 

    }
}
