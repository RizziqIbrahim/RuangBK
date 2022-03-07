<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    protected $table = "soals";
    protected $fillable = [
        'jenis_soal',
        'content',
        'category_id',
    ];
}
