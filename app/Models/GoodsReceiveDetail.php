<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsReceiveDetail extends Model
{
    use HasFactory;

    protected $fillable = ['goods_receive_id','conversion_id','item_name','sku','qty','purchase_price'];

    public function goodsReceive()
    {
        return $this->belongsTo(GoodsReceive::class);
    }
}
