<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailSale extends Model
{
    use HasFactory;
    protected $fillable = ['sales_id','conversion_id','item_name','sku','qty','unit','unit_price','bruto_price','discount','nett_total','notes','status'];

    public function sales()
    {
        return $this->belongsTo(Sale::class);
    }
}
 