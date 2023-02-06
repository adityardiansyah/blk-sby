<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MasterColor;
use App\Models\MasterSize;
use App\Models\ProductMaster;
use Illuminate\Http\Request;

class ProductMasterController extends Controller
{
    public function syncProductMaster(ProductMaster $productMaster)
    {
        try {
            $data_erp = $productMaster->syncProductMasterERP();
            $data_db = $productMaster->count();
            if(count($data_erp) > $data_db){
                foreach ($data_erp as $key => $value) {
                    $match = [
                        'code' => $value->code,
                        'name' => $value->name,
                        'name_warehouse' => $value->name_warehouse
                    ];

                    $arr = [
                        'brand' => $value->brand,
                        'variant' => $value->variant,
                        'motive' => $value->motive,
                    ];
                    ProductMaster::updateOrCreate($match, $arr);
                    
                }
            }
            return response()->json(['message' => 'success', 'date' => date('Y-m-d H:i:s')]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            $data = [];
            $message = "";
            $query = $request['query'];
            if($query !== null){
                $data = ProductMaster::where('name','like','%'.$query.'%')->get();
                if(!empty($data)){
                    $message = "Data ditemukan";
                }else{
                    $message = "Data tidak ditemukan!";
                }
            }
            return response()->json([
                'message' => $message,
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'data' => [],
            ], 400);
        }
    }

    public function get_color()
    {
        try{
            $data = [];
            $message = "";
            $data = MasterColor::orderBy('name','asc')->get();
            if(!empty($data)){
                $message = "Data ditemukan";
            }else{
                $message = "Data tidak ditemukan!";
            }
            return response()->json([
                'message' => $message,
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'data' => [],
            ], 400);
        }
    }

    public function get_sizes()
    {
        try{
            $data = [];
            $message = "";
            $data = MasterSize::orderBy('name','asc')->get();
            if(!empty($data)){
                $message = "Data ditemukan";
            }else{
                $message = "Data tidak ditemukan!";
            }
            return response()->json([
                'message' => $message,
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'data' => [],
            ], 400);
        }
    }
}
