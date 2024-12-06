<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket_kelas extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'paket_kelas';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_kelas',
        'durasi',
        'harga',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }
}
