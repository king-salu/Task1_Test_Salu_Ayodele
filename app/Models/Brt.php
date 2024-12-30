<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brt extends Model
{
    use HasFactory;
    protected $table = 'brt';
    protected $fillable = [
        'user_id',
        'reserved_amount',
        'status',
        'brt_code',
    ];
}
