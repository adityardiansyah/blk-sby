<?php
namespace App\Http\Repository;

use App\Models\Seller;
use Illuminate\Support\Facades\Auth;

class SellerRepository{
    protected $seller;

    public function __construct(Seller $con) {
        $this->seller = $con;
    }

    public function get_all()
    {
        return $this->seller->orderBy('created_at','desc')->get();
    }

    public function get_data_by_id($id)
    {
        return $this->seller->where('id', $id)->first();
    }

    public function create($data)
    {
        $result = [];
        $arr = [
        ];

        $check = $this->seller->where('sku', $data['sku'])->where('shop_id', Auth::seller()->seller->shop_id)->first();
        if(empty($check)){
            $result = $this->seller->create($arr);
        }else{
            $result = false;
        }
        return $result;
    }

}