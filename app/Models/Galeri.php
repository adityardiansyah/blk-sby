<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use HasFactory;
    protected $fillable = [
        'judul',
        'deskripsi',
        'status'
    ];
    protected $table = 'galeri';

    /**
     * Get all of the foto_galeri for the Galeri
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fotoGaleri()
    {
        return $this->hasMany(FotoGaleri::class, 'galeri_id', 'id');
    }
}
