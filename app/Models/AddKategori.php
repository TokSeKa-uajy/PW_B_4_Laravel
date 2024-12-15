<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddKategori extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'add_kategoris';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama',
        'deskripsi',
    ];
}
