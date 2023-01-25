<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'departemen',
        'tanggal_pinjam',
        'item_a',
        'item_b',
        'item_c',
        'tanggal_pengembalian',
        'jenis_revisi',
        'tanggal',
        'tanggal_data',
        'jenis_data',
        'nama_data',
        'detail_revisi',
        'alasan_revisi',
        'nama_program',
        'latar_belakang',
        'proses_bisnis',
        'sop',
        'benefit',
        'konsekuensi',
        'fitur',
        'prosedur_dan_dokumen',
        'topik',
        'jam_mulai',
        'jam_selesai',
        'departemen',
        'jabatan',
        'keperluan_email',
        'keperluan_browsing'
    ];
}
