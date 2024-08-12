<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function user() : HasOne
    {
        return $this->hasOne(User::class , 'id', 'user_id');
    }

    public function bimbel() : HasOne
    {
        return $this->hasOne(Bimbel::class, 'id', 'bimbel_id');
    }
}
