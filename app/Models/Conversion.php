<?php

namespace App\Models;

use App\Models\ProductMaster;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Conversion extends Model
{
    use HasFactory;

    protected $fillable = ['product_master_id','seller_id','shop_id','name_item','sku', 'qty_final','price','color','size'];
    protected $table = 'conversions';

    // public function getSkuAttribute()
    // {
    //     return $this->sku.' - '.$this->color.' - '.$this->size;
    // }

    // public function MasterColor()
    // {
    //     return $this->belongsTo('App\Models\MasterColor', 'color');
    // }
}

