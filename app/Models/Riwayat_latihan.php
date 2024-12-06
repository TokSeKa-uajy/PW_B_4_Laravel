<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Riwayat_latihan extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    protected $table = 'riwayat_latihan';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_user',
        'id_Pemesanan_Kelas',
        'tanggal_latihan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
