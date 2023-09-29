<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adjusment extends Model
{
    use HasFactory;

    protected $fillable = ['conversion_id', 'type', 'qty', 'notes', 'status'];

    public function conversion()
    {
        return $this->hasOne(Conversion::class);
    }
}
