<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Conversion;
use App\Models\Shop;
use App\Http\Repository\ConversionRepository;

class ConversionController extends Controller
{
    protected $conversionRepository;

    public function __construct(ConversionRepository $conversion) {
        $this->conversionRepository = $conversion;
        $this->middleware(function ($request, $next){
            Session::put('menu_active','conversion');
            return $next($request);
        });
    }

    public function conversion()
    {
        return $this->conversionRepository;
    }

    public function api($shop_id)
    {
        return response()->json([
            'success' => true,
            'data' => $this->conversionRepository->get_data_by_shop($shop_id)
        ]);
    }

    public function index()
    {
        $data = Conversion::get();
        $shop = Shop::select('name');
        return view('page.conversion', compact('data', 'shop'));
    }
}
