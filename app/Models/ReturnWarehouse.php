<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnWarehouse extends Model
{
    use HasFactory;

    protected $fillable = ["seller_id","shop_id","trans_no","trans_date","notes","file_attachment","status"];

    /**
     * Get all of the detail for the ReturnWarehouse
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detail()
    {
        return $this->hasMany(ReturnWarehouseDetail::class);
    }
}
