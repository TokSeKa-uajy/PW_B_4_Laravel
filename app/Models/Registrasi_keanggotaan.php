<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registrasi_keanggotaan extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    protected $table = 'registrasi_keanggotaan';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_keanggotaan',
        'tanggal_pembayaran',
        'total_pembayaran',
        'status_pembayaran',
        'jenis_pembayaran',
    ];

    public function keanggotaan()
    {
        return $this->belongsTo(Keanggotaan::class, 'id_keanggotaan');
    }
}
