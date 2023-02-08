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
        $arr = [
            "shop_id" => $data['shop_id'],
            "user_id" => $data['user_id'],
            "no_seller" => $this->generate_noreg(),
            "name" => $data['name'],
            "phone" => $data['phone'],
            "photo" => $data['photo'],
            "email" => $data['email'],
            "status" => "active",
        ];
        $result = $this->seller->create($arr);
        
        return $result;
    }

    public function generate_noreg()
    {
        $data = $this->seller->get()->count();
        $format = "A";
        $no = $data + 1;
        if($data == 0){
            $result = $format.'001';
        }else{
            $result = $format.substr("000",0,3-strlen($no)).$no;
        }
        return $result;
    }

}