<?php
namespace App\Http\Repository;

use App\Models\Conversion;
use App\Models\GoodsReceiveDetail;

class DetailGoodsReceiveRepository{
    protected $detailGoodsReceive, $conversion;

    public function __construct(GoodsReceiveDetail $gr, Conversion $con) {
        $this->detailGoodsReceive = $gr;
        $this->conversion = $con;
    }

    public function create($data, $id)
    {
        $arr = [
            "goods_receive_id" => $id,
            "conversion_id" => $data['conversion_id'],
            "item_name" => $data['item_name'],
            "sku" => $data['sku'],
            "qty" => $data['qty'],
            "purchase_price" => $data['purchase_price'],      
        ];
        
        return $this->detailGoodsReceive->create($arr);
    }

    public function update($data, $id)
    {
        $match = [
            "goods_receive_id" => $id,
            "conversion_id" => $data['conversion_id'],
            "item_name" => $data['item_name'],
            "sku" => $data['sku'],
        ];
        $arr = [
            "qty" => $data['qty'],
            "purchase_price" => $data['purchase_price'],      
        ];
        
        return $this->detailGoodsReceive->updateOrCreate($match, $arr);
    }

    public function delete($good_receive_id)
    {
        $this->detailGoodsReceive->where('goods_receive_id', $good_receive_id)->delete();
    }
    
    public function delete_by_id($id)
    {
        $this->detailGoodsReceive->find($id)->delete();
    }
    
    public function get_all_by_gr_id($gr_id)
    {
        return $this->detailGoodsReceive->where('goods_receive_id', $gr_id)->get();
    }

}