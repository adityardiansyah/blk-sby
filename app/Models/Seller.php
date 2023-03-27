<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;
    protected $fillable = ["shop_id","user_id","no_seller","name","phone","photo","email","status"];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function goodsReceives()
    {
        return $this->hasOne(GoodsReceive::class);
    }
}
