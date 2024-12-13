<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Riwayat_latihan extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    protected $table = 'riwayat_latihan';
    protected $primaryKey = 'id_riwayat_latihan';

    protected $fillable = [
        'id_user',
        'id_pemesanan_Kelas',
        'tanggal_latihan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function pemesanan_kelas()
    {
        return $this->belongsTo(Pemesanan_kelas::class, 'id_pemesanan_Kelas');
    }
}
