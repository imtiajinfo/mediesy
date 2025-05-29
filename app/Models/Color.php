<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Color extends Model
{
    use HasFactory;

    protected $fillable = ['name_english', 'name_bangla', 'code', 'description', 'status',];

    public function item_infos(): HasMany
    {
        return $this->hasMany(ItemInfo::class);
    }
}
