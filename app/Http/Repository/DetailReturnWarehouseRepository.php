<?php
namespace App\Http\Repository;

use App\Models\Conversion;
use App\Models\ReturnWarehouse;
use App\Models\ReturnWarehouseDetail;
use Illuminate\Support\Facades\Auth;

class DetailReturnWarehouseRepository{
    protected $returnWarehouse, $conversion, $returnWarehouseDetail;

    public function __construct(Conversion $conv, ReturnWarehouse $rw, ReturnWarehouseDetail $rwd) {
        $this->returnWarehouse = $rw;
        $this->conversion = $conv;
        $this->returnWarehouseDetail = $rwd;
    }

    public function get_data_by_shop($id)
    {
        return $this->returnWarehouseDetail->where('shop_id', $id)->orderBy('created_at', 'desc')->get();
    }

    public function get_data_by_id($id)
    {
        return $this->returnWarehouseDetail->where('id', $id)->first();
    }

    public function create($id, $data)
    {
        $conversion = $this->conversion->find($data['conversion_id']);
        if(!empty($conversion)){
            $return = [
                "return_warehouse_id" => $id,
                "conversion_id" => $data['conversion_id'],
                "item_name" => $conversion->name_item,
                "sku" => $conversion->sku,
                "qty" => $data['qty'],
                "purchase_price" => $conversion->price,
                "status" => "open"
            ];
            $this->returnWarehouseDetail->create($return);
        }
    }

    public function delete_by_id($id)
    {
        $this->returnWarehouseDetail->find($id)->delete();
    }

    public function delete($return_id)
    {
        $this->returnWarehouseDetail->where('return_warehouse_id', $return_id)->delete();
    }
    
}