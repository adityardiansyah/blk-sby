<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPelatihan extends Model
{
    use HasFactory;
    protected $table = 'riwayat_pelatihan';

    /**
     * Get all of the pelatihan for the RiwayatPelatihan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pelatihan()
    {
        return $this->hasMany(Pelatihan::class, 'id', 'pelatihan_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'id', 'user_id');
    }
}
