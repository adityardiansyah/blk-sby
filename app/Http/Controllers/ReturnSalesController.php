<?php

namespace App\Http\Controllers;
use App\Models\ReturnSale;
use App\Models\Shop;
use App\Models\Seller;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Http\Repository\ReturnSalesRepository;
use Illuminate\Http\Request;

class ReturnSalesController extends Controller
{
    protected $ReturnSalesRepository, $detailSalesRepossitory, $conversionRepository;
    
    public function __construct(ReturnSalesRepository $sales) {
        $this->ReturnSalesRepository = $sales;
        $this->middleware(function ($request, $next){
            Session::put('menu_active','returnsales');
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
            
            $query = ReturnSale::query();
            
            if ($date_start && $date_end) {
                $query->whereBetween('date_return', [$date_start, $date_end]);
            }
            
            if ($shop_id) {
                $query->where('shop_id', $shop_id);
            }
            
            if ($seller_id) {
                $query->where('seller_id', $seller_id);
            }

            $data = $query->get();
        } else {
            $data = $this->ReturnSalesRepository->get_data_all(); 
        }
        
        return view('page.returnsales', compact('data', 'shop', 'seller'));
    }
}
