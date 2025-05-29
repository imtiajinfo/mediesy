<?php

namespace App\Models;

use App\Models\ItemInfo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Size extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'name_bangla', 'size', 'description', 'status'];

    public function items()
    {
        return $this->hasMany(ItemInfo::class);
    }
}
