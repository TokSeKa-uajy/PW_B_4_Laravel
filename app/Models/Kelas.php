<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'kelas';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_pelatih',
        'id_kategori',
        'nama_kelas',
        'deskripsi',
        'hari',
        'jam_mulai',
        'durasi',
        'harga',
        'kapasitas_kelas',
    ];

    public function pelatih()
    {
        return $this->belongsTo(Pelatih::class, 'id_pelatih');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori_kelas::class, 'id_kategori');
    }
}
