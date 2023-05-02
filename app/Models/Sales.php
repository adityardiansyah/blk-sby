<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;
    protected $fillable = ["invoice","trans_date","shop_id","seller_id","total_tax","notes","status"];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
}
