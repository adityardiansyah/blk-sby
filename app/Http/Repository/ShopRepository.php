<?php
namespace App\Http\Repository;

use App\Models\Shop;
use Illuminate\Support\Facades\Auth;

class ShopRepository{
    protected $shop;

    public function __construct(Shop $con) {
        $this->shop = $con;
    }

    public function get_all()
    {
        return $this->shop->orderBy('created_at','desc')->get();
    }

    public function get_data_by_id($id)
    {
        return $this->shop->where('id', $id)->first();
    }


}