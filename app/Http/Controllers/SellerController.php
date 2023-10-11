<?php

namespace App\Http\Controllers;

use App\Http\Repository\SellerRepository;
use App\Http\Repository\ShopRepository;
use App\Http\Repository\UserRepository;
use App\Models\Group;
use App\Models\UserGroup;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SellerController extends Controller
{
    public function __construct(
        private SellerRepository $sellerRepository,
        private ShopRepository $shopRepository,
        private UserRepository $userRepository
    ) {
        $this->middleware(function ($request, $next){
            Session::put('menu_active','/seller');
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $data = $this->sellerRepository->get_all();
        $shop = $this->shopRepository->get_all();
        $role = Group::where('id','<>',1)->get();

        return view('page.seller', compact('data','shop', 'role'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|unique:users',
            'email' => 'required|unique:sellers',
        ]);

        $user = $this->userRepository->create($request->all());
        $allowedfileExtension = ['jpg','png','jpeg'];
        $img = "";
        if($request->hasFile('img')){
            $extension = $request->file('img')->getClientOriginalExtension();
            $check = in_array($extension,$allowedfileExtension);
            if($check){
                $img = $request->file('img')->store('profile');
            }else{
                return response()->json([
                    'message' => 'invalid file format',
                    'success' => false,
                ], 400);
            }
        }
        $request->merge(['user_id' => $user->id]);
        $request->merge(['photo' => $img]);

        $this->sellerRepository->create($request->all());
        UserGroup::create([
            'user_id' => $user->id,
            'group_id' => $request->group_id
        ]);
        
        return response()->json([
            'success'=>true,
            'message' => 'Berhasil ditambahkan!' 
        ]);
    }

    public function show($id) {
        $data = $this->sellerRepository->get_data_by_id($id);
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

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'no_seller' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'status' => 'required|in:active,nonactive'
        ]);

        Seller::where('id', $id)->update([
            'no_seller' => $request->input('no_seller'),
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'status' => $request->input('status')
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Diubah!'
        ]);
    }
}
