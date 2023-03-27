<?php

namespace App\Http\Controllers;
use App\Models\Sales;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Http\Repository\SalesRepository;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    protected $SalesRepository, $detailSalesRepossitory, $conversionRepository;
    
    public function __construct(SalesRepository $sales) {
        $this->SalesRepository = $sales;
        $this->middleware(function ($request, $next){
            Session::put('menu_active','sales');
            return $next($request);
        });
    }
    public function index(Request $request)
    {
        $data = $this->SalesRepository->get_data_all();
        return view('page.sales', compact('data'));
    }
}
