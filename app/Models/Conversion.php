<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversion extends Model
{
    use HasFactory;

    protected $fillable = ['product_master_id','seller_id','shop_id','name_item','sku', 'qty_final','price','color','size'];

    public function productMaster()
    {
        return $this->belongsTo(ProductMaster::class);
    }

    // public function getSkuAttribute()
    // {
    //     return $this->sku.' - '.$this->color.' - '.$this->size;
    // }

    // public function MasterColor()
    // {
    //     return $this->belongsTo('App\Models\MasterColor', 'color');
    // }
}
