<?php
namespace App\Http\Repository;

use App\Models\Conversion;

class ConversionRepository{
    protected $conversion;

    public function __construct(Conversion $con) {
        $this->conversion = $con;
    }

    public function get_data_by_shop($id)
    {
        return $this->conversion->where('shop_id', $id)->get();
    }

    public function get_data_by_id($id)
    {
        return $this->conversion->where('id', $id)->first();
    }

    public function create($data)
    {
        $arr = [
            'product_master_id' => $data['product_master_id'],
            'seller_id' => $data['seller_id'],
            'shop_id' => $data['shop_id'],
            'name_item' => $data['name_item'],
            'qty_final' => 0,
            'sku' => $data['sku'],
            'price' => $data['price']
        ];

        $check = $this->conversion->where('sku', $data['sku'])->first();
        if(empty($check)){
            $result = $this->conversion->create($arr);
        }
        return $result;
    }

    public function update($id, $data)
    {
        $arr = [
            'product_master_id' => $data['product_master_id'],
            'seller_id' => $data['seller_id'],
            'shop_id' => $data['shop_id'],
            'name_item' => $data['name_item'],
            'sku' => $data['sku'],
            'price' => $data['price']
        ];
        return $this->conversion->where('id', $id)->update($arr);
    }
}