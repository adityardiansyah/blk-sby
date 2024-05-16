<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','pelatihan_id','alamat','no_hp','pendidikan','usia','sub_kejuruan','foto','foto_ktp','tanggal_pendaftaran'];
    protected $table = 'pendaftaran';

    /**
     * Get the user that owns the Pendaftaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function pelatihan()
    {
        return $this->belongsTo(Pelatihan::class, 'pelatihan_id', 'id');
    }
}
