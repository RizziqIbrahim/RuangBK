<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = "admins";
    protected $fillable = [
        'nama_admin',
        'user_id',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'foto'
    ];
}
