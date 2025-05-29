<?php

namespace App\Models;

use App\Models\Sell;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'slug', 'name', 'phone', 'email',
        'email_verified_at', 'password', 'password_confirmation',
        'gst_number', 'tax_number', 'country', 'state',
        'city', 'postcode', 'address', 'previous_due',
    ];
    public function sales()
    {
        return $this->hasMany(Sell::class);
    }
}
