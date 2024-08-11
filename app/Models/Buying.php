<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buying extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'live_id',
        'bimbel_id',
        'awal',
        'akhir',
    ];
}
