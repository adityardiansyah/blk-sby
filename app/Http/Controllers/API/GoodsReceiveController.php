<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repository\ConversionRepository;
use App\Http\Repository\DetailGoodsReceiveRepository;
use App\Http\Repository\GoodsReceiveRepository;
use App\Http\Repository\ManagementStockRepository;
use App\Models\FileGoodsReceived;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Svg\Tag\Rect;

class GoodsReceiveController extends Controller
{
    protected $goodsReceiveRepository, $detailGoodsReceiveRepository, $conversionRepository, $manageStockRepository;

    public function __construct(GoodsReceiveRepository $goods, 
                                DetailGoodsReceiveRepository $dtGoods, 
                                ConversionRepository $con,
                                ManagementStockRepository $manageStock) {
        $this->goodsReceiveRepository = $goods;
        $this->detailGoodsReceiveRepository = $dtGoods;
        $this->conversionRepository = $con;
        $this->manageStockRepository = $manageStock;
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
            ], 400);
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
            ], 400);
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
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $file = "";

            $data = $this->goodsReceiveRepository->update($request->all(), $file, $id);
            if($id && !empty($request->detail)){
                $this->detailGoodsReceiveRepository->delete($id);
                foreach ($request->detail as $key => $value) {
                    $this->detailGoodsReceiveRepository->update($value, $id);
                }
    
                return response()->json([
                    'data' => $data,
                    'message' => 'success updated',
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'data' => [],
                'message' => $th->getMessage()
            ], 400);
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
            ], 400);
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
                            'message' => 'Cannot open! '.$checkStock['data'].', Not enough stock',
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

            $this->manageStockRepository->update_status($id, $request->type);

            return response()->json([
                'message' => 'success updated',
                'data' => $detail,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'data' => [],
            ], 400);
        }
    }

    public function upload_attachment(Request $request)
    {
        try {
            if(!$request->hasFile('file_attachment')) {
                return response()->json([
                    'message' => 'File upload not found!',
                    'data' => [],
                ], 400);
            }

            $allowedfileExtension = ['pdf','jpg','png','jpeg'];

            if(!empty($request->file_attachment)){
                foreach ($request->file_attachment as $value) {
                    $extension = $value->getClientOriginalExtension();
                    $check = in_array($extension,$allowedfileExtension);
                    if($check){
                        $path = $value->store('goodsreceive');
        
                        $sv = new FileGoodsReceived;
                        $sv->filename = $path;
                        $sv->goods_receive_id = $request->goods_receive_id;
                        $sv->save();
                    }else{
                        return response()->json([
                            'message' => 'invalid file format',
                            'data' => [],
                        ], 400);
                    }
                }
            }
            return response()->json([
                'message' => 'success insert',
                'data' => [],
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'data' => [],
            ], 400);
        }
    }

    public function delete_file($id)
    {
        try {
            FileGoodsReceived::find($id)->delete();
            return response()->json([
                'message' => 'success deleted',
                'data' => []
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'data' => []
            ], 400);
        }
    }
}
