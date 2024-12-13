<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'kelas';
    protected $primaryKey = 'id_kelas';

    protected $fillable = [
        'id_pelatih',
        'id_kategori_kelas',
        'nama_kelas',
        'deskripsi',
        'hari',
        'jam_mulai',
        'durasi',
        'kapasitas_kelas',
    ];

    public function pelatih()
    {
        return $this->belongsTo(Pelatih::class, 'id_pelatih');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori_kelas::class, 'id_kategori_kelas');
    }
}
