<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOpname extends Model
{
    use HasFactory;
    protected $table = 'stock_opname';
    protected $fillable = ["seller_id","shop_id","trans_no","trans_date","notes","status"];

    /**
     * Get all of the detail for the StockOpname
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
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
        return $this->hasMany(DetailStockOpname::class);
    }

    public function file_attachment()
    {
        return $this->belongsTo(StockOpname::class);
    }
}
