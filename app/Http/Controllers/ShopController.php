<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            Session::put('menu_active', 'shop');
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
        // $request->merge(['status'=>'active']) ;
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required',
        //     'location' => 'required',
        //     'address' => 'required',
        //     'latitude' => 'required|numeric',
        //     'longitude' => 'required|numeric'
        // ]);

        // if ($validator->fails()) {
        //     return response()->json($validator->errors(),422);
        // }

        // $check = Shop::where('name',$request->name)->first();

        //     if(empty($check)){
        //         return response()->json([
        //             'success' => true,
        //             'type' => 'error',
        //             'icon' => 'warning',
        //             'message' => 'Toko Sudah Ada',
        //             'data' => $data
        //         ]);
        //     }else {

        //         $data = Shop::create([
        //         $data->name = $request->name,
        //         $data->location = $request->location,
        //         $data->address = $request->address,
        //         $data->latitude = $request->latitude,
        //         $data->longitude = $request->longitude,
        //         $data->save()
        //         ]);
        //     return response()->json([
        //         'success' => true,
        //         'type' => 'success',
        //         'icon' => 'success',
        //         'message' => 'berhasil ditamabah',
        //         'data' => $data
        //     ]);
        // }

        try {
            // $shop=new Shop;
            // return $request->all();
            $check = Shop::where('name', $request->name)->first();
            if (empty($check)) {
                $request->merge(['status' => 'active']);

                Shop::create($request->all());

                $arr = [
                    'success' => true,
                    'message' => 'Berhasil ditambahkan!',
                ];
            } else {
                $arr = [
                    'success' => false,
                    'message' => 'Toko sudah ada!',
                ];
            }
            return response()->json($arr);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal ditambahkan!',
            ]);
        }
    }

    public function edit($id)
    {
        $data = Shop::find($id);
        if (!empty($data)) {
            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'data' => [],
            ]);
        }
    }

    public function update(Request $request)
    {
        $id = $request->id;
        if ($id) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'location' => 'required',
                'address' => 'required',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            } else {
                $data = Shop::find($id);
                $data->name = $request->name;
                $data->location = $request->location;
                $data->address = $request->address;
                $data->latitude = $request->latitude;
                $data->longitude = $request->longitude;
                $request->merge(['status' => 'active']);
                $data->save();

                return redirect()->to('/shop')->with('message', ['type' => 'success','content' => 'Data berhasil diupdate']);
            }
        }
    }
}
