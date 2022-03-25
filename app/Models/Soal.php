<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    protected $table = "soals";
    protected $fillable = [
        'soal',
        'angket_id',
        'created_by',
        'updated_by',
        'created_at',
        'updated_by'
    ];
}
