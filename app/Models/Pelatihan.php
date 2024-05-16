<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelatihan extends Model
{
    use HasFactory;
    protected $table = 'pelatihan';
    protected $fillable = [
        'nama_pelatihan',
        'slug',
        'deskripsi',
        'tanggal_awal',
        'tanggal_akhir',
        'tanggal_pelaksanaan',
        'kuota',
        'status',
        'berkas_seleksi',
        'sub_kejuruan',
    ];

    function riwayat_pelatihan(){
        return $this->hasMany(RiwayatPelatihan::class, 'pelatihan_id', 'id');
    }

    /**
     * Get the sub_kejuruan associated with the Pelatihan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function kejuruan()
    {
        return $this->hasOne(Kejuruan::class, 'id', 'sub_kejuruan');
    }
}
