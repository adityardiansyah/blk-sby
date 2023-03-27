<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;
    protected $table = 'shop';
    protected $fillable =['name','address','location','latitude','longitude','status'];

    public function goodsReceives()
    {
        return $this->hasOne(GoodsReceive::class);
    }
}
