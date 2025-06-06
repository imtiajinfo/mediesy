<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GameHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
    ];
}
