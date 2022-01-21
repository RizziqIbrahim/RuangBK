<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = "gurus";
    protected $fillable = [
        'nama_guru',
        'user_id',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'foto'
    ];
}
