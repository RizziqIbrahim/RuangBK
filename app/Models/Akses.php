<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akses extends Model
{
    protected $table = "akses";
    protected $fillable = [
        'angket_id',
        'user',
        'time',
        'start_at',
        'finish_at',
        'open_by',
        'kode',
    ];
}
