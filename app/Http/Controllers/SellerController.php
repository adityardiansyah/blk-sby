<?php

namespace App\Http\Controllers;

use App\Http\Repository\SellerRepository;
use App\Http\Repository\ShopRepository;
use App\Http\Repository\UserRepository;
use App\Models\Group;
use App\Models\Seller;
use App\Models\UserGroup;
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
            Session::put('menu_active','seller');
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
    public function edit($id) {
        $data = Seller::findOrFail($id);
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
        return view('page.seller', compact('data','seller'));
        }
        public function show($id)
        {
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
            'password' => 'required|string|min:6',
            'status' => 'required|in:active,nonactive',
        ]);

        Seller::where('id', $id)->update([
            'password' => $request->input('password'),
            'status' => $request->input('status'),
        ]);

        return redirect()->to('/users')->with('message', [
            'type' => 'success',
            'content' => 'Data berhasil diupdate'
        ]);
    }
        // $type = $request->type;
        // $seller = Seller::find($id);
        // $seller->no_seller=$request->input('no_seller');
        // $seller->nama=$request->input('name');
        // $seller->phone=$request->input('phone');
        // $seller->created_at=$request->input('created_at');
        // $seller->status=$request->input('status');

        // $seller->save();
        // return response()->json([
        //     'success'=>true,
        //     'message'=>'Status Berhasil Diubah',
        // ]);
    //     $validator = Validator::make($request->all(),[
    //         // 'seller_id'=>'required',
    //         'no_seller'=>'required',
    //         'name'=>'required',
    //         'phone'=>'required',
    //         'status'=>'required',
    //     ]);
    //     if ($validator->fails()) {
    //         return response()->json($validator->errors(),422);
    //     }
    //     $sellerRepository->where('id', $id)->update([
    
    //         'no_seller'=>$request->no_seller,
    //         'name'=>$request->name,
    //         'phone'=>$request->phone,
    //         'status'=>$request->status,
    //     ]);
    //     return response()->json([
    //         'success'=>true,
    //         'message'=>'Data Berhasil Diupdate!',
    //         'data'=>$salesRepository
    //     ]);
    // }
    // public function update(Request $request,$id)
    // {
    //     $seller = Seller::find($id);
    //     $seller->no_seller=$request->input('no_seller');
    //     $seller->nama=$request->input('name');
    //     $seller->phone=$request->input('phone');
    //     $seller->created_at=$request->input('created_at');
    //     $seller->status=$request->input('status');

    //     $seller->save();
    //     return redirect()->to('/seller')->with('message',['type' =>'success','content'=>'Data Berhasil Ditambahkan']);
    // }
    // public function save(Request $request,$id )
    // {
    //     $seller = $this->sellerRepository->create($request->all());
    //     $this->sellerRepository->create($request->all());
        
    //     return response()->json([
    //         'success'=>true,
    //         'message' => 'Berhasil diupdate!' 
    //     ]);
    // }
}
