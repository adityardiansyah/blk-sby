<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class FileGoodsReceived extends Model
{
    use HasFactory;
    protected $table = 'file_goods_receives';

    public function getFilenameAttribute()
    {
        return asset('storage/'.$this->attributes['filename']);
    }
}
