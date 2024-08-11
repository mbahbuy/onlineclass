<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Siswa extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'school',
        'phone',
        'status',
    ];

    public function user() : HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
