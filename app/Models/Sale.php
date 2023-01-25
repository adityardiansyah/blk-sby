<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $fillable = ['seller_id','shop_id','invoice','trans_date','include_tax','tax_persen','total_price','total_tax','total_discount','notes','status'];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function detail()
    {
        return $this->hasMany(DetailSale::class, 'sales_id','id');
    }
}
