<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket_keanggotaan extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    protected $table = 'paket_keanggotaan';
    protected $primaryKey = 'id_paket_keanggotaan';

    protected $fillable = [
        'durasi',
        'harga',
    ];
}
