<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registrasi_keanggotaan extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    protected $table = 'registrasi_keanggotaan';
    protected $primaryKey = 'id_registrasi_keanggotaan';

    protected $fillable = [
        'id_user',
        'id_paket_keanggotaan',
        'tanggal_pembayaran',
        'total_pembayaran',
        'status_pembayaran',
        'jenis_pembayaran',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function paket_keanggotaan()
    {
        return $this->belongsTo(Paket_keanggotaan::class, 'id_paket_keanggotaan');
    }
}
