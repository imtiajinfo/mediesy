<?php

namespace App\Models;

use App\Models\Store;
use App\Models\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'store_id',
        'user_id',
        'role',
        'name',
        'slug',
        'phone',
        'email',
        'password',
        'country',
        'district',
        'upazila',
        'postcode',
        'address',
        'nid',
        'status',

        'salary',
        'image',
        'nid_font',
        'nid_back',
        'reference_details'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
