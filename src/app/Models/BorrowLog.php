<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'borrower_name',
        'borrower_contact',
        'borrowed_at',
        'returned_at',
        'status',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
