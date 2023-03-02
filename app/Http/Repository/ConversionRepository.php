<?php
namespace App\Http\Repository;

use App\Models\Conversion;
use Illuminate\Support\Facades\Auth;

class ConversionRepository{
    protected $conversion;

    public function __construct(Conversion $con) {
        $this->conversion = $con;
    }

    public function get_data_by_shop($id)
    {
        $data = $this->conversion->with('productMaster')->where('shop_id', $id)->orderBy('created_at','desc')->get();
        $res = $data->map(function($con){
            return collect([
                'id' => $con->id,
                'product_master_id' => $con->product_master_id,
                'seller_id' => $con->seller_id,
                'shop_id' => $con->shop_id,
                'name_item' => $con->name_item,
                'sku' => $con->sku,
                'qty_final' => $con->qty_final,
                'price' => $con->price,
                'color' => $con->color,
                'size' => $con->size,
                'product_master' => $con->productMaster
            ]);
        });
        return $res;
    }

    public function get_data_by_id($id)
    {
        return $this->conversion->where('id', $id)->first();
    }

    public function create($data)
    {
        $result = [];
        $arr = [
            'product_master_id' => $data['product_master_id'],
            'seller_id' => Auth::user()->seller->id,
            'shop_id' => Auth::user()->seller->shop_id,
            'name_item' => $data['name_item'],
            'qty_final' => 0,
            'sku' => $data['sku'],
            'price' => $data['price'],
            'color' => $data['color']?? '',
            'size' => $data['size']?? ''
        ];

        $check = $this->conversion->where('sku', $data['sku'])
        ->where('color', $data['color'])
        ->where('size', $data['size'])
        ->where('shop_id', Auth::user()->seller->shop_id)->first();
        if(empty($check)){
            $result = $this->conversion->create($arr);
        }else{
            $result = false;
        }
        return $result;
    }

    public function update($id, $data)
    {
        $arr = [
            'product_master_id' => $data['product_master_id'],
            'seller_id' => Auth::user()->seller->id,
            'shop_id' => Auth::user()->seller->shop_id,
            'name_item' => $data['name_item'],
            'sku' => $data['sku'],
            'price' => $data['price'],
            'color' => $data['color']?? '',
            'size' => $data['size']?? ''
        ];
        return $this->conversion->where('id', $id)->update($arr);
    }

    public function update_qty($id_sku, $qty, $type)
    {
        $data = $this->conversion->where('id', $id_sku)->first();
        if(!empty($data)){
            if($type == 'IN'){
                $qty_result = $data->qty_final + $qty;
            }elseif($type == 'OUT'){
                if($data->qty_final >= $qty){
                    $qty_result = $data->qty_final - $qty;
                }else{
                    return ['error' => true, 'data'=>$data->sku];
                }
            }
            $arr = [ 'qty_final' => $qty_result ];
            $this->conversion->where('id', $id_sku)->update($arr);
        }
    }

    public function checkStockItem($data, $type)
    {
        if(!empty($data)){
            foreach ($data as $key => $value) {
                $arr = $this->conversion->where('id', $value->conversion_id)->first();
                if(!empty($arr)){
                    if($type == 'OUT'){
                        if($arr->qty_final < $value->qty){
                            return ['error' => true, 'data'=>$arr->sku];
                        }
                    }
                }
            }
            return ['error' => false];
        }
    }
}