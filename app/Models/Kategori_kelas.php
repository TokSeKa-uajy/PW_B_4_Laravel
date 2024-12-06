<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori_kelas extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'kategori_kelas';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama_kategori',
        'deskripsi_kategori',
    ];
}
