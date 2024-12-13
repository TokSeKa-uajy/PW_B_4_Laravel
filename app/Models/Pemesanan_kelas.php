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
        'id_kelas',
        'id_paket_kelas',
        'tanggal_pemesanan',
        'status_pembayaran',
        'jenis_pembayaran',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    public function paket_kelas()
    {
        return $this->belongsTo(Paket_kelas::class, 'id_paket_kelas');
    }
}

