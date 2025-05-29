<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Boot extends Model
{
    use HasFactory;

    protected $fillable = [
        'boot_name',
        'user_id',
        'room_id',
        'active_status',
    ];


    public function rooms()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function desks()
    {
        return $this->hasMany(Desk::class, 'desk_id');
    }
}
