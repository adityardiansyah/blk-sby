<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\StockOpname;
use App\Models\DetailStockOpname;
use App\Http\Repository\StockOpnameRepository;
use App\Http\Repository\DetailStockOpnameRepository;

class StockOpnameController extends Controller
{
    protected $stock, $conversionRepository, $detailStockOpnameRepository;
    
    public function __construct(StockOpnameRepository $stock, DetailStockOpnameRepository $detail_stock) {
        $this->stock = $stock;
        $this->detailStockOpnameRepository = $detail_stock;
        $this->middleware(function ($request, $next){
            Session::put('menu_active','stockopname');
            return $next($request);
        });
    }

    public function index(){
        $data = $this->stock->get_data_all();
        foreach ($data as $key => $value) {
            $detail = $this->detailStockOpnameRepository->get_data_sum_qty($value->id);
            $value->total_qty = $detail;
        }
        return view('page.stockopname', compact('data'));
    }

    public function show($id) {
        $data = $this->stock->get_data_by_id($id);
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
            StockOpname::find($id)->update(['status'=>'open']);
        }
        return response()->json([
            'success' => true,
            'message' => 'Status Berhasil Diubah!',
        ]); 

    }
}
