<?php
namespace App\Http\Repository;

use App\Models\Conversion;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserRepository{
    protected $user;

    public function __construct(User $con) {
        $this->user = $con;
    }

    public function get_all()
    {
        return $this->user->get();
    }

    public function get_data_by_id($id)
    {
        return $this->user->where('id', $id)->first();
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
            'price' => $data['price']
        ];

        $check = $this->user->where('sku', $data['sku'])->where('shop_id', Auth::user()->seller->shop_id)->first();
        if(empty($check)){
            $result = $this->user->create($arr);
        }else{
            $result = false;
        }
        return $result;
    }

}