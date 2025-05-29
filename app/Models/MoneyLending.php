<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MoneyLending extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_bangla',
        'email',
        'phone',
        'nid',
        'country',
        'division',
        'district',
        'city',
        'Area',
        'postcode',
        'parent_address',
        'permanent_address',
        'from_date',
        'to_date',
        'to_amount',
        'recv_amount',
        'due_amount',
        'monthly_profit',
        'is_closed',
    ];

    public function sales()
    {
        return $this->hasMany(Sell::class);
    }
}
