<?php

namespace App\Models;

use App\Models\PurchaseOrders;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'slug', 'name', 'phone', 'email',
        'email_verified_at', 'password', 'password_confirmation',
        'gst_number', 'tax_number', 'country', 'state',
        'city', 'postcode', 'address', 'previous_due',
        'company_name',
        'company_tin_number',
        'supplier_destination',
        'brand'

    ];
    public function sales()
    {
        return $this->hasMany(Sell::class);
    }

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrders::class, 'supplier_id');
    }
}
