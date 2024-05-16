<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoGaleri extends Model
{
    use HasFactory;
    protected $fillable = [
        'galeri_id',
        'foto',
    ];
    protected $table = 'foto_galeri';

    /**
     * Get the galeri that owns the FotoGaleri
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function galeri()
    {
        return $this->belongsTo(Galeri::class);
    }
}
