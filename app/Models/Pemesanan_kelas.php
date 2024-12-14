<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan_kelas extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'pemesanan_kelas';
    protected $primaryKey = 'id_pemesanan_kelas';

    protected $fillable = [
        'id_user',
        'id_paket_kelas',
        'tanggal_pemesanan',
        'jenis_pembayaran',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function paket_kelas()
    {
        return $this->belongsTo(Paket_kelas::class, 'id_paket_kelas');
    }
}

