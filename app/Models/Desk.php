<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Desk extends Model
{
    use HasFactory;


    protected $fillable = [
        'desk_id',
        'user_id',
        'room_id',
        'boot_id',
        'active_status',
    ];



    public function rooms()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function boots()
    {
        return $this->belongsTo(Boot::class, 'boot_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
