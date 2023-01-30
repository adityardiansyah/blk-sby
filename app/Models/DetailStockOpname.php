<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailStockOpname extends Model
{
    use HasFactory;
    protected $table = 'detail_stock_opname';
    protected $fillable = ["stock_opname_id","conversion_id","item_name","sku","qty"];
}
