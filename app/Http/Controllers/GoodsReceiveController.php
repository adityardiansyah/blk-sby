<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\GoodsReceive;
use App\Models\Shop;
use App\Models\Seller;
use App\Http\Repository\GoodsReceiveRepository;
use App\Http\Repository\ManagementStockRepository;

class GoodsReceiveController extends Controller
{
    protected $goodsReceiveRepository, $detailGoodsReceiveRepository, $conversionRepository, $manageStockRepository;

    public function __construct(GoodsReceiveRepository $goods, ManagementStockRepository $manageStock)
    {
        $this->goodsReceiveRepository = $goods;
        $this->manageStockRepository = $manageStock;

        $this->middleware(function ($request, $next) {
            Session::put('menu_active', 'goodsreceive');
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $shop = Shop::all();
        $seller = Seller::all();
        
        if (request()->date_start || request()->date_end || request()->shop_id || request()->seller_id) {
            $date_start = $request->input('date_start');
            $date_end = $request->input('date_end');
            $shop_id = $request->input('shop_id');
            $seller_id = $request->input('seller_id');
            
            $query = GoodsReceive::query();
            
            if ($date_start && $date_end) {
                $query->whereBetween('sent_date', [$date_start, $date_end]);
            }
            
            if ($shop_id) {
                $query->where('shop_id', $shop_id);
            }
            
            if ($seller_id) {
                $query->where('seller_id', $seller_id);
            }

            $data = $query->get();
        } else {
            $data = $this->goodsReceiveRepository->get_data_all();
        }

        return view('page.goodsreceive', compact('data', 'shop', 'seller'));
    }

    public function show($id)
    {
        $data = $this->goodsReceiveRepository->get_data_by_id($id);
        if (!empty($data)) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } else {
            return response()->json([
                'success' => false,
                'data' => []
            ]);
        }
    }

    public function confirm($id, Request $request)
    {
        $type = $request->type;
        if ($type == "open") {
            return $this->manageStockRepository->update_status($id, $type);
        }
        return response()->json([
            'success' => true,
            'message' => 'Status Berhasil Diubah!',
        ]);
    }
}
