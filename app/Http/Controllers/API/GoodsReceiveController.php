<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repository\DetailGoodsReceiveRepository;
use App\Http\Repository\GoodsReceiveRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoodsReceiveController extends Controller
{
    protected $goodsReceiveRepository, $detailGoodsReceiveRepository;

    public function __construct(GoodsReceiveRepository $goods, DetailGoodsReceiveRepository $dtGoods) {
        $this->goodsReceiveRepository = $goods;
        $this->detailGoodsReceiveRepository = $dtGoods;
    }

    public function index()
    {
        try {
            $shop_id = Auth::user()->seller->shop_id;
            $data = $this->goodsReceiveRepository->get_data_by_shop($shop_id);
            
            return response()->json([
                'message' => 'Data found',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Data not found',
                'data' => []
            ]);
        }
    }

    public function store(Request $request)
    {
        try {
            $file = "";
            if(!empty($request->file('file_attachment'))){
                $request->validate([
                    'file_attachment' => 'mimes:jpg,jpeg,png|max:2048',
                ]);
                $name = $request->file('file_attachment')->getClientOriginalName();
                $path = $request->file('file_attachment')->store('public/files/goodsreceive');
                $file = $name.$path;
            }
            
            $data = $this->goodsReceiveRepository->create($request->all(), $file);
            if($data->id && !empty($request->detail)){
                foreach ($request->detail as $key => $value) {
                    $this->detailGoodsReceiveRepository->create($value, $data->id);
                }
    
                return response()->json([
                    'data' => $data,
                    'message' => 'success inserted',
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'data' => [],
                'message' => 'insert failed',
                'error' => 500
            ]);
        }
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        try {
            $file = "";
            if(!empty($request->file('file_attachment'))){
                $request->validate([
                    'file_attachment' => 'mimes:jpg,jpeg,png|max:2048',
                ]);
                $name = $request->file('file_attachment')->getClientOriginalName();
                $path = $request->file('file_attachment')->store('public/files/goodsreceive');
                $file = $name.$path;
            }
            
            $data = $this->goodsReceiveRepository->update($request->all(), $file, $id);
            if($id && !empty($request->detail)){
                foreach ($request->detail as $key => $value) {
                    $this->detailGoodsReceiveRepository->update($value);
                }
    
                return response()->json([
                    'data' => $data,
                    'message' => 'success updated',
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'data' => [],
                'message' => 'insert failed',
                'error' => 500
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $this->detailGoodsReceiveRepository->delete($id);
            $this->goodsReceiveRepository->delete($id);
            
            return response()->json([
                'message' => 'success deleted',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'delete failed',
                "error" => 500
            ]);
        }
    }

    public function update_status($id, Request $request)
    {
        try{
            $this->goodsReceiveRepository->update_status($id, $request->type);

            return response()->json([
                'message' => 'success updated',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => [],
                'message' => $th->getMessage(),
                'error' => 500
            ]);
        }
    }
}
