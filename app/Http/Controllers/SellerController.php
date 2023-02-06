<?php

namespace App\Http\Controllers;

use App\Http\Repository\SellerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SellerController extends Controller
{
    public function __construct(
        private SellerRepository $sellerRepository
    ) {
        Session::put('menu_active','seller');
    }

    public function index(Request $request)
    {
        $data = $this->sellerRepository->get_all();

        return view('page.seller', compact('data'));
    }
}
