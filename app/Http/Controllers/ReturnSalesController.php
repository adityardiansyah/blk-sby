<?php

namespace App\Http\Controllers;
use App\Models\ReturnSales;
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
        $data = $this->ReturnSalesRepository->get_data_all(); 
        
        return view('page.returnsales', compact('data'));
    }
}
