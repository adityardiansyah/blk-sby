<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\StockOpname;
use App\Models\Shop;
use App\Models\Seller;
use App\Models\DetailStockOpname;
use App\Http\Repository\StockOpnameRepository;
use App\Http\Repository\DetailStockOpnameRepository;

class StockOpnameController extends Controller
{
    protected $stock, $conversionRepository, $detailStockOpnameRepository;

    public function __construct(StockOpnameRepository $stock, DetailStockOpnameRepository $detail_stock)
    {
        $this->stock = $stock;
        $this->detailStockOpnameRepository = $detail_stock;
        $this->middleware(function ($request, $next){
            Session::put('menu_active','/stockopname');
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

            $query = StockOpname::query();

            if ($date_start && $date_end) {
                $query->whereBetween('trans_date', [$date_start, $date_end]);
            }

            if ($shop_id) {
                $query->where('shop_id', $shop_id);
            }

            if ($seller_id) {
                $query->where('seller_id', $seller_id);
            }

            $data = $query->get();
        } else {
            $data = $this->stock->get_data_all();
            foreach ($data as $key => $value) {
                $detail = $this->detailStockOpnameRepository->get_data_sum_qty($value->id);
                $value->total_qty = $detail;
            }
        }

        return view('page.stockopname', compact('data', 'shop', 'seller'));
    }

    public function show($id)
    {
        $data = $this->stock->get_data_by_id($id);
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
            StockOpname::find($id)->update(['status' => 'open']);
        }
        return response()->json([
            'success' => true,
            'message' => 'Status Berhasil Diubah!',
        ]);
    }
}
