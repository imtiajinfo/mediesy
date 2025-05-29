<?php

namespace App\Models;

use App\Models\Store;
use App\Models\Upazila;
use App\Models\District;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory;
    // protected $table = 'countries';
    protected $primary_key = 'id';
    protected $fillable = ['name'];

    /**
     * Get all of the comments for the Country
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function districts(): HasMany
    {
        return $this->hasMany(District::class, 'country_id', 'id');
    }

    public function upazilas(): HasMany
    {
        return $this->hasMany(Upazila::class, 'district_id', 'id');
    }

    public function stores(): HasMany
    {
        return $this->hasMany(Store::class);
    }

    public function employee(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
