<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Angket extends Model
{
    use HasFactory;
    protected $table = "angket";
    protected $fillable = [
        'nama_angket',
        'keterangan',
        'created_by',
        'updated_by',
    ];
}
