<?php

namespace App\Models;

use App\Models\Area;
use App\Models\Country;
use App\Models\Upazila;
use App\Models\District;
use App\Models\Division;
use App\Models\ItemStoreMapping;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Store extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = [
        'name',
        'slug',
        'phone',
        'email',
        'country',
        'district',
        'upazila',
        'postcode',
        'address',
        'store_type',
        'company_id',
        'status',
    ];

    public function itemStoreMappings()
    {
        return $this->hasMany(ItemStoreMapping::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }
    public function upazilla()
    {
        return $this->belongsTo(Upazila::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
