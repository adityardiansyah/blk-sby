<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnSale extends Model
{
    use HasFactory;
    protected $fillable = ['seller_id','shop_id','conversion_id','no_return','date_return','date_sale','invoice','item_name','sku','qty','unit','unit_price','bruto_price','discount','nett_total','notes'];
}
