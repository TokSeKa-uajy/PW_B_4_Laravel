<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Umpan_balik extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    protected $table = 'umpan_balik';
    protected $primaryKey = 'id_umpan_balik';

    protected $fillable = [
        'id_user',
        'id_pemesanan_kelas',
        'rating',
        'komentar',
        'tanggal_umpan_balik',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function pemesanan_kelas()
    {
        return $this->belongsTo(Pemesanan_kelas::class, 'id_pemesanan_kelas');
    }
}
