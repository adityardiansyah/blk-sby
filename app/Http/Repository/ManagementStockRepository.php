<?php
namespace App\Http\Repository;

use App\Models\GoodsReceive;
use Illuminate\Support\Facades\Auth;
use App\Http\Repository\ConversionRepository;
use App\Http\Repository\DetailGoodsReceiveRepository;
use App\Http\Repository\GoodsReceiveRepository;
use Illuminate\Http\Request;

class ManagementStockRepository{

    protected $goodsReceiveRepository, $detailGoodsReceiveRepository, $conversionRepository;

    public function __construct(GoodsReceiveRepository $goods, DetailGoodsReceiveRepository $dtGoods, ConversionRepository $con) {
        $this->goodsReceiveRepository = $goods;
        $this->detailGoodsReceiveRepository = $dtGoods;
        $this->conversionRepository = $con;
    }

    public function update_status($id, $type)
    {
        try{
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

            $this->goodsReceiveRepository->update_status($id, $type);

            return response()->json([
                'message' => 'success updated',
                'data' => $detail,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'data' => [],
            ], 400);
        }
    }
}