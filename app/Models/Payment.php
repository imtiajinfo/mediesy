<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'sell_id', 'customer_id', 'sells_status',
        'ref_no', 'created_by', 'payment_type', 'payment_note', 'txn_code', 'payment_details',
        'payment_method', 'total_payable_amount', 'total_paid_amount', 'total_due_amount',
    ];

    public function sell()
    {
        return $this->belongsTo(Sell::class, 'sell_id');
    }
}
