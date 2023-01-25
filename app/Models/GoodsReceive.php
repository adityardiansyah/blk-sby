<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsReceive extends Model
{
    use HasFactory;

    protected $fillable = ['seller_id','shop_id','no_sj_from','no_sj_receive','sent_date','receive_date','notes','file_attachment','status'];
    
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function detailGR()
    {
        return $this->hasMany(GoodsReceiveDetail::class);
    }
}
