<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Uom extends Model
{
    use HasFactory;
    protected $fillable = [
        'uom_set_id',
        'uom_short_code',
        'uom_desc',
        'relative_factor',
        'fraction_allow',
        'is_active',
        'created_by',
        'updated_by',
        'local_desc',
    ];
    public function iteminfos()
    {
        return $this->hasMany(ItemInfo::class);
    }
}
