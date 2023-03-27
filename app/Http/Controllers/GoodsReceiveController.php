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
}
