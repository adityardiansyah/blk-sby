<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\GoodsReceive;
use App\Http\Repository\GoodsReceiveRepository;

class GoodsReceiveController extends Controller
{
    protected $goodsReceiveRepository, $detailGoodsReceiveRepository, $conversionRepository;
    
    public function __construct(GoodsReceiveRepository $goods) {
        $this->goodsReceiveRepository = $goods;
        $this->middleware(function ($request, $next){
            Session::put('menu_active','goodsreceive');
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
            GoodsReceive::find($id)->update(['status'=>'open']);
        }
        return response()->json([
            'success' => true,
            'message' => 'Status Berhasil Diubah!',
        ]); 

    }
}
