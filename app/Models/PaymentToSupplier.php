<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentToSupplier extends Model
{
    use HasFactory;
    protected $fillable = [
        'supplier_id',
        'spo_id',
        'payable_amount',
        'due_amout',
        'paid_amount',
        'is_closed',
        'updated_at',
    ];
}
