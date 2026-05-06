<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan model ini
    protected $table = 'branches';

    // Kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'name',
        'latitude',
        'longitude',
    ];
}
