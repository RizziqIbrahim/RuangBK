<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = "siswas";
    protected $fillable = [
        'nama_siswa',
        'user_id',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'foto'
    ];
}
