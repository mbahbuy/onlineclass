<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bimbel extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'harga',
        'day_start',
        'day_end',
        'time_start',
        'time_end',
    ];
}
