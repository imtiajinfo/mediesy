<?php

namespace App\Models;

use App\Models\Area;
use App\Models\Country;
use App\Models\Upazila;
use App\Models\Division;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class District extends Model
{
    use HasFactory;

    public function upazilas()
    {
        return $this->hasMany(Upazila::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function areas()
    {
        return $this->hasMany(Area::class);
    }
}
