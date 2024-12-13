<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelatih extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'pelatih';
    protected $primaryKey = 'id_pelatih';

    protected $fillable = [
        'nama_depan',
        'nama_belakang',
        'foto_profil',
        'jenis_kelamin',
    ];
}
