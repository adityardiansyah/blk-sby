<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMasterDetail extends Model
{
    use HasFactory;

    protected $fillable = ['product_master_id','sku'];

    public function product_master()
    {
        return $this->belongsTo(ProductMaster::class);
    }
}
