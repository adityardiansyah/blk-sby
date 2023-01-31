<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repository\ConversionRepository;
use App\Http\Repository\DetailGoodsReceiveRepository;
use App\Http\Repository\GoodsReceiveRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoodsReceiveController extends Controller
{
    protected $goodsReceiveRepository, $detailGoodsReceiveRepository, $conversionRepository;

    public function __construct(GoodsReceiveRepository $goods, DetailGoodsReceiveRepository $dtGoods, ConversionRepository $con) {
        $this->goodsReceiveRepository = $goods;
        $this->detailGoodsReceiveRepository = $dtGoods;
        $this->conversionRepository = $con;
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
                $path = $request->file('file_attachment')->store('files/goodsreceive','public');
                $file = $path;
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
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function show($id)
    {
        try {
            if($id){
                $data = $this->goodsReceiveRepository->get_data_by_id($id);
                return response()->json([
                    'message' => 'Data found',
                    'data' => $data
                ]);
            }
            
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Data not found',
                'data' => []
            ]);
        }
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
                'message' => 'insert failed'
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
                'data' => []
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'data' => []
            ]);
        }
    }

    public function update_status($id, Request $request)
    {
        try{
            $type = $request->type;
            $detail = $this->goodsReceiveRepository->get_data_by_id($id);
            if(!empty($detail->detail) && $detail->status !== $type){
                if($type === "open"){
                    $checkStock = $this->conversionRepository->checkStockItem($detail->detail, 'OUT');
                    if($checkStock['error']){
                        return response()->json([
                            'message' => 'Cannot sale! '.$checkStock['data'].', Not enough stock',
                            'data' => []
                        ], 400);
                    }
                }

                foreach ($detail->detail as $key => $value) {
                    if($type === "confirmed" && $detail->status !== $type){
                        $this->conversionRepository->update_qty($value->conversion_id, $value->qty, 'IN');
                    }elseif($type === "open" && $detail->status !== $type){
                        $update = $this->conversionRepository->update_qty($value->conversion_id, $value->qty, 'OUT');
                        if(!empty($update['error'])){
                            return response()->json([
                                'message' => 'Cannot open!, '.$update['data'].' Not enough stock',
                                'data' => []
                            ], 400);
                        }
                    }
                }
            }

            $this->goodsReceiveRepository->update_status($id, $request->type);

            return response()->json([
                'message' => 'success updated',
                'data' => $detail,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'data' => [],
            ]);
        }
    }
}
