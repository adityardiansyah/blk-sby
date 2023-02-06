<?php

namespace App\Http\Controllers;

use App\Http\Repository\SellerRepository;
use App\Http\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $us) {
        Session::put('menu_active','users');
        $this->userRepository = $us;
    }
    
    public function index(Request $request)
    {
        $data = $this->userRepository->get_all();
        return view('page.users', compact('data'));
    }
}
