<?php

namespace App\Models;

use App\Models\Sell;
use App\Models\Customer;
use App\Models\ItemInfo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Warranty extends Model
{
    use HasFactory;
    protected $fillable = [
        'store_id',
        'customer_id',
        'sells_id',
        'item_id',
        'type',
        'duration',
        'start_date',
        'end_date',
        'notes',
        'status'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'status' => 'boolean'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function sells()
    {
        return $this->belongsTo(Sell::class);
    }

    public function items()
    {
        return $this->belongsTo(ItemInfo::class, 'item_id');
    }
}
