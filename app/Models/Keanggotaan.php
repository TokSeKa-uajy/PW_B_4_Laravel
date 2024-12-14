<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keanggotaan extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    protected $table = 'keanggotaan';

    protected $fillable = [
        'id_user',
        'id_paket_keanggotaan',
        'tanggal_mulai',
        'tanggal_berakhir',
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
