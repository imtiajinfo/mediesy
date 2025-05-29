<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'desk_id',
        'coin',
        'active_status',
    ];


    public function desks()
    {
        return $this->belongsTo(Desk::class, 'desk_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
