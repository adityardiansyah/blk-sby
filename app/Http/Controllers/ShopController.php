<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;

class ShopController extends Controller
{
    public function __construct() {
        $this->middleware(function ($request, $next){
            Session::put('menu_active','shop');
            return $next($request);
        });
    }

    public function index()
    {
        $data = Shop::all();
        return view('page.shop', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            // return $request->all();
            $check = Shop::where('name',$request->name)->first();
            if(empty($check)){
                $request->merge(['status'=>'active']) ;

                Shop::create($request->all());

                $arr = [
                    'success' => true,
                    'message' => 'Berhasil ditambahkan!' 
                ];
            }else{
                $arr = [
                    'success' => false,
                    'message' => 'Toko sudah ada!' 
                ];
            }
            return response()->json($arr);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal ditambahkan!' 
            ]);
        }
    }

    public function edit($id) {
    
        $data = Shop::find($id);
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
        // return view('/shop',['Shop'=>$data]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'location' => 'required',
            'address' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {
            $shop = Shop::find($id);
            $shop->name = $request->name;
            $shop->location = $request->location;
            $shop->address = $request->address;
            $shop->latitude = $request->latitude;
            $shop->longitude = $request->longitude;
            $shop->save();
    
            return response()->json(['success' => 'Data has been updated successfully']);
        }
        // $request->merge(['status'=>'active']) ;
        // $request->validate([
        //     'name'=> $data,
        //     'location'=>'required',
        //     'address'=>'required',
        //     'longitude'=>'required',
        //     'latitude'=>'required',    
        // ]); 
        // $data = [

        // 'name'=> $request->name,
        // 'location'=> $request->location,
        // 'address'=> $request->address,
        // 'latitude'=> $request->latitude,
        // 'longitude'=> $request->longitude
        // ];
        // Shop::where('name',$id)->update($data);
        // return redirect()->to('/shop')->with('success','Berhasil update data');
    }
}
