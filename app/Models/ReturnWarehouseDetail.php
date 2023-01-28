<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnWarehouseDetail extends Model
{
    use HasFactory;
    protected $fillable = ["return_warehouse_id","conversion_id","item_name","sku","qty","purchase_price","status"];

    /**
     * Get the returnWarehouse that owns the ReturnWarehouseDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function returnWarehouse(): BelongsTo
    {
        return $this->belongsTo(ReturnWarehouse::class);
    }
}
